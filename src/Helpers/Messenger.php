<?php

namespace mar\messenger\Helpers;


use mar\messenger\Models\Message;
use Carbon\Carbon;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Pusher\Pusher;

class Messenger
{
    /**
     * Get the currently authenticated guard.
     *
     * This method loops through all guards defined in `config/auth.php`
     * and returns the first guard that has an authenticated user.
     * It is useful in applications that support multiple authentication
     * guards (e.g., users, admins, employees, etc.).
     *
     * @return string|null Returns the guard name if authenticated, otherwise null.
     */
    public static function currentGuard()
    {
        $guardNames = array_keys(config('auth.guards'));

        foreach ($guardNames as $guard) {
            if (auth($guard)->check()) {
                return $guard;
            }
        }

        return null;
    }

    /**
     * Get the currently authenticated user from the active guard.
     *
     * This method first determines the active guard using `currentGuard()`
     * and then returns the authenticated user associated with that guard.
     * If no guard is authenticated, it returns null.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public static function currentUser()
    {
        $guard = self::currentGuard();
        return $guard ? auth($guard)->user() : null;
    }

    /**
     * Get login user Id
     *
     * @return mixed
     */
    public static function loginId()
    {
        $id = 0;
        $user = self::currentUser();
        if ($user) {
            $id = $user->id;
        }

        return $id;
    }

    /**
     * Get current authenticated user type (config key).
     *
     * @return string|null
     */
    public static function loginType()
    {
        $user = self::currentUser();

        if (!$user) {
            return null;
        }

        foreach (config('messenger.models') as $type => $model) {
            if ($user instanceof $model) {
                return $type;
            }
        }

        return null;
    }

    /**
     * Get First letters from user name
     *
     * @param $name
     * @return string
     */
    public static function nameLetters($name)
    {
        $initials = '';
        if ($name) {
            $initials = collect(explode(' ', $name))->map(function ($item) {
                return strtoupper($item[0]);
            })->implode('');
        }

        return $initials;
    }

    /**
     * Get unseen messages of selected user
     *
     * @param $userId
     * @return mixed
     */
    public static function getUnseenMessagesCount($userId)
    {
        return Message::unseenMessages($userId);
    }

    /**
     * generate chat id
     *
     * @return string
     */
    public static function generateChatId()
    {
        $timestamp = now()->timestamp;
        $randomNumber = mt_rand(100000, 999999);

        $chatId = $timestamp . $randomNumber;

        // Ensure the chat ID is exactly 12 digits
        $chatId = str_pad($chatId, 12, '0', STR_PAD_RIGHT);

        return $chatId;
    }

    /**
     * Upload file
     *
     * @param $request
     * @param $input
     * @param $path
     * @return array
     */
    public static function uploadFile($request, $input, $path)
    {
        $arr = [];
        if ($request->hasFile($input)) {
            $file = $request->file($input);
            // Get file size in bytes
            $fileSize = $file->getSize();

            $arr[$input] = $fileName = 'laravel-messenger-' . time() . '-' . uniqid(rand()) . '.' . $file->extension();
            $arr[$input . '_original_name'] = $request->$input->getClientOriginalName();
            $arr['file_type'] = '.' . str_replace('.', '', $file->extension());
            $arr['file_size'] = self::formatSizeUnits($fileSize);
            $storageType = config('messenger.storage_disk_name');
            if ($storageType == 'public') {
                $destinationPath = public_path($path);
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $file->move($destinationPath, $fileName);
            }
            if ($storageType == 'google') {
                $storage = new StorageClient([
                    'projectId' => env('GOOGLE_CLOUD_PROJECT_ID'),
                    'keyFilePath' => public_path(env('GOOGLE_CLOUD_KEY_FILE')),
                ]);

                $bucket = $storage->bucket(env('GOOGLE_CLOUD_BUCKET'));
                $bucket->upload(fopen($file, 'r+'), [
                    'name' => $path . '/' . $fileName,
                    'predefinedAcl' => 'publicRead',
                ]);
            }
            if ($storageType == 's3') {
                $s3ImageUrl = Storage::disk('s3')->putFileAs($path, $file, $fileName);
                Storage::disk('s3')->url($s3ImageUrl);
            }
        }

        return $arr;
    }

    /**
     * Function to convert bytes to a human-readable format
     *
     * @param $bytes
     * @return string
     */
    private static function formatSizeUnits($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return sprintf("%.2f", $bytes) . ' ' . $units[$i];
    }

    /**
     * Get gile icons
     *
     * @param $extension
     * @return string
     */
    public static function getFileIcon($extension)
    {
        $fileIcons = config('messenger.file_icons');
        $extension = strtolower(str_replace('.', '', $extension));

        return $fileIcons[$extension] ?? 'far fa-file'; // Default icon if extension not found
    }

    /**
     * Create new message
     *
     * @param $data
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Pusher\ApiErrorException
     * @throws \Pusher\PusherException
     */
    public static function createMessage($data)
    {
        $objMessage = new Message();
        $user = self::currentUser();
        $receiverType = !empty($data['receiver_type']) ? $data['receiver_type'] : 'user';

        $objMessage->sender_id = $user->id;
        $objMessage->sender_type = get_class($user);

        $objMessage->receiver_id = $data['receiver_id'];
        $objMessage->receiver_type = self::getReceiverModel($receiverType);

        $objMessage->chat_id = $data['chat_id'];
        if (!empty($data['message'])) {
            $objMessage->message = $data['message'];
        }
        if (!empty($data['file'])) {
            $objMessage->file = $data['file'];
            $objMessage->file_original_name = $data['file_original_name'];
            $objMessage->file_type = $data['file_type'];
            $objMessage->file_size = $data['file_size'];
        }
        $objMessage->save();

        $senderMessages[] = self::getLatestMessage($data['chat_id']);
        $senderMessageHtml = view('messenger::partials._conversation', [
            'messages' => $senderMessages,
            'user_avatar_name' => self::nameLetters($objMessage->receiver->name),
        ])->render();

        $receiverMessages[] = self::getLatestMessage($data['chat_id'], $data['receiver_id']);
        $receiverMessageHtml = view('messenger::partials._conversation', [
            'messages' => $receiverMessages,
            'user_avatar_name' => self::nameLetters($objMessage->sender->name),
        ])->render();

        $senderThreadHtml = view('messenger::partials._chat-users', [
            'chatUsers' => Message::fetchChatUsers()
        ])->render();

        $receiverThreadHtml = view('messenger::partials._chat-users', [
            'chatUsers' => Message::fetchChatUsers($data['receiver_id'], $receiverType)
        ])->render();


        self::triggerPusher('messenger-user-' . $receiverType . '-' . $data['receiver_id'], 'new-message', [
            'chat_id' => $data['chat_id'],
            'sender_id' => $user->id,
            'receiver_id' => $data['receiver_id'],
            'message_html' => $receiverMessageHtml,
            'thread_html' => $receiverThreadHtml,
            'user_avatar_name' => self::nameLetters($objMessage->receiver->name),
        ]);

        self::triggerPusher('messenger-user-' . Messenger::loginType() . '-' . $user->id, 'new-message', [
            'chat_id' => $data['chat_id'],
            'sender_id' => $user->id,
            'receiver_id' => $data['receiver_id'],
            'message_html' => $senderMessageHtml,
            'thread_html' => $senderThreadHtml,
            'user_avatar_name' => self::nameLetters($objMessage->sender->name),
        ]);
    }

    /**
     * Latest message
     *
     * @param $chatId
     * @param $receiverId
     * @return array
     */
    private static function getLatestMessage($chatId, $receiverId = 0)
    {
        $loginId = !empty($receiverId) ? $receiverId : self::loginId();
        $message = Message::where('chat_id', $chatId)->latest()->first();
        $arrMessages = [];
        if (!empty($message)) {
            $message->is_send = $message->sender_id == $loginId ? 1 : 0;
            $message->message_time = Carbon::parse($message->created_at)->format('g:i a');
            $message->message_file = !empty($message->file) ? self::getStoragePath($message->file) : '';
            $arrMessages = $message->toArray();
        }

        return $arrMessages;
    }

    /**
     * Get the model class for a given receiver type.
     *
     * This method retrieves the corresponding model class from the
     * `messenger.models` configuration using the provided type key.
     * It allows the messenger package to support multiple authenticatable
     * models such as User, Employee, Client, Contractor, etc.
     *
     * @param string $type The receiver type key defined in messenger config.
     * @return string|null Returns the fully qualified model class name or null if not found.
     */
    public static function getReceiverModel($type)
    {
        $models = config('messenger.models');

        return $models[$type] ?? null;
    }

    /**
     * Get the configured type key for a given model class.
     *
     * This method searches the `messenger.models` configuration and returns
     * the corresponding type key (e.g., user, employee, client, contractor, resident)
     * for the provided fully qualified model class name.
     *
     * It is useful when the messenger system stores or receives a model class
     * (e.g., App\Models\User) and you need to determine its configured type
     * key defined in `config/messenger.php`.
     *
     * @param string $modelClass The fully qualified model class name.
     * @return string|false Returns the type key if found, otherwise false.
     */
    public static function getTypeFromModel($modelClass)
    {
        return array_search($modelClass, config('messenger.models'));
    }

    /**
     * Get the receiver's name using receiver ID and type.
     *
     * This method resolves the receiver's model dynamically based on the
     * provided receiver type and then fetches the record using the receiver ID.
     * It is useful in applications where messages can be sent between multiple
     * model types (e.g., User, Employee, Client, Resident, etc.).
     *
     * @param int $receiverId The ID of the receiver.
     * @param string $receiverType The receiver type key defined in messenger config.
     * @return string|null Returns the receiver name if found, otherwise an empty string.
     */
    public static function getReceiverName($receiverId, $receiverType)
    {
        $model = self::getReceiverModel($receiverType);

        if (!$model) {
            return null;
        }

        $user = $model::find($receiverId);

        return !empty($user) ? $user->name : '';
    }

    /**
     * Get storage file path
     *
     * @param $file
     * @return string
     */
    public static function getStoragePath($file)
    {
        $storagePath = '';
        $storageType = config('messenger.storage_disk_name');
        if ($storageType == 'public') {
            $storagePath = asset('laravel-messenger/uploads');
        }
        if ($storageType == 'google') {
            $storagePath = 'https://storage.googleapis.com/' . getenv('GOOGLE_CLOUD_BUCKET') . '/laravel-messenger/uploads';
        }
        if ($storageType == 's3') {
            $storagePath = 'https://' . getenv('AWS_BUCKET') . '.s3.' . getenv('AWS_DEFAULT_REGION') . '.amazonaws.com/laravel-messenger/uploads';
        }
        $filePath = $storagePath . '/' . $file;

        return $filePath;
    }

    /**
     * Trigger the pusher to save messages
     *
     * @param $channel
     * @param $event
     * @param $data
     * @return object
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Pusher\ApiErrorException
     * @throws \Pusher\PusherException
     */
    public static function triggerPusher($channel, $event, $data)
    {
        $pusher = new Pusher(
            config('messenger.pusher.key'),
            config('messenger.pusher.secret'),
            config('messenger.pusher.app_id'),
            config('messenger.pusher.options')
        );

        return $pusher->trigger($channel, $event, $data);
    }
}
