<?php

namespace mar\messenger\Http\Controllers;

use App\Http\Controllers\Controller;
use mar\messenger\Models\Message;
use mar\messenger\Contracts\UserResolver;
use mar\messenger\Helpers\Messenger;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MessengerController extends Controller
{
    private $data = [], $message = '', $success = false;

    protected $resolver;

    public function __construct(UserResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['users'] = $this->resolver->getUsers();
        $this->data['chatUsers'] = $this->chatUsers();

        return view('messenger::index', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            if (empty($data['message']) && empty($data['file'])) {
                $this->message = "Please enter a message or select a file to send.";
            } else {
                if ($request->hasFile('file')) {
                    $image = Messenger::uploadFile($request, 'file', 'laravel-messenger/uploads');
                    $data['file'] = !empty($image) ? $image['file'] : '';
                    $data['file_original_name'] = !empty($image) ? $image['file_original_name'] : '';
                    $data['file_type'] = !empty($image) ? $image['file_type'] : '';
                    $data['file_size'] = !empty($image) ? $image['file_size'] : '';
                }
                $objMessage = Messenger::createMessage($data);
                $this->success = true;
                $this->message = "Message sent successfully.";

                $senderMessages = [Messenger::getLatestMessage($data['chat_id'])];
                $senderMessageHtml = view('messenger::partials._conversation', [
                    'messages' => $senderMessages,
                    'user_avatar_name' => Messenger::nameLetters($objMessage->receiver->name),
                ])->render();

                $senderThreadHtml = view('messenger::partials._chat-users', [
                    'chatUsers' => Message::fetchChatUsers()
                ])->render();

                $this->data = [
                    'message_html' => $senderMessageHtml,
                    'thread_html' => $senderThreadHtml,
                    'chat_id' => $objMessage->chat_id,
                ];
            }
        } catch (\Exception $exception) {
            $this->message = $exception->getMessage();
        }

        return response()->json(['success' => $this->success, 'message' => $this->message, 'data' => $this->data]);
    }

    /**
     * Renders the HTML for a single message (called via the renderMessageRoute
     * endpoint after the client receives a Pusher "new-message" event).
     * We don't send full HTML through the socket anymore — this function exists
     * so the client can fetch only the HTML for the specific message it needs.
     *
     * @param $messageId
     * @return string
     */
    public static function renderMessageHtml($messageId)
    {
        $message = Message::with('sender', 'receiver')->find($messageId);

        $currentUser = Messenger::currentUser();

        $avatarUser = ($message->sender_id == $currentUser->id && $message->sender_type == get_class($currentUser))
            ? $message->receiver
            : $message->sender;

        return view('messenger::partials._conversation', [
            'messages' => [$message],
            'user_avatar_name' => Messenger::nameLetters($avatarUser->name),
        ])->render();
    }

    /**
     * Renders the HTML for the chat threads/sidebar list.
     * After a new-message Pusher event, the client hits this route to refresh
     * the left-side thread list (last message, ordering, unread state, etc.)
     *
     * @param null $userId
     * @param null $userType
     * @return string
     */
    public static function renderThreadsHtml($userId = null, $userType = null)
    {
        $chatUsers = $userId
            ? Message::fetchChatUsers($userId, $userType)
            : Message::fetchChatUsers();

        return view('messenger::partials._chat-users', [
            'chatUsers' => $chatUsers
        ])->render();
    }

    /**
     * Update messenger mode Dark/light
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateMessengerMode(Request $request)
    {
        try {
            $data = $request->all();
            $type = Messenger::loginType();
            $modelName = Messenger::getReceiverModel($type);
            $modelName::where('id', Messenger::loginId())->update(['messenger_mode' => $data['messenger_mode']]);
            $this->success = true;
            $this->message = 'Mode updated successfully.';
        } catch (\Exception $exception) {
            $this->message = $exception->getMessage();
        }

        return response()->json(['success' => $this->success, 'message' => $this->message]);
    }

    /**
     * Make message seen
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function messageSeen(Request $request)
    {
        try {
            $data = $request->all();
            Message::where('receiver_id', $data['receiver_id'])
                ->where('sender_id', Messenger::loginId())
                ->where('is_seen', 0)
                ->update(['is_seen' => 1]);
            $this->success = true;
            $this->message = 'Mode updated successfully.';
        } catch (\Exception $exception) {
            $this->message = $exception->getMessage();
        }

        return response()->json(['success' => $this->success, 'message' => $this->message]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        try {
            $data = $request->all();
            $columnName = !empty($data['chat_id']) ? 'chat_id' : 'id';
            $columnValue = !empty($data['chat_id']) ? $data['chat_id'] : $data['id'];
            $obj = Message::query()->select('delete_user_id')->where($columnName, $columnValue)->first();
            if (empty($obj->delete_user_id)) {
                Message::query()->where($columnName, $columnValue)->update([
                    'delete_user_id' => Messenger::loginId(),
                    'delete_user_type' => Messenger::loginType()
                ]);
            } else {
                Message::query()->where($columnName, $columnValue)->delete();
            }
            $this->success = true;
            $this->message = !empty($data['chat_id']) ? 'Chat deleted successfully' : 'Message deleted successfully';
        } catch (\Exception $exception) {
            $this->message = $exception->getMessage();
        }

        return response()->json(['success' => $this->success, 'message' => $this->message]);
    }

    /**
     * Get selected user record
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser(Request $request)
    {
        $data = $request->all();
        if (!empty($data['user_id'])) {
            $userId = $data['user_id'];
            $userType = !empty($data['receiver_type']) ? $data['receiver_type'] : 'user';

            $currentUserId = Messenger::loginId();
            $currentUserType = Messenger::loginType();

            $currentUserTypeModal = Messenger::getReceiverModel($currentUserType);
            $userTypeModal = Messenger::getReceiverModel($userType);

            $user = Message::where(function ($q) use ($userId, $userTypeModal, $currentUserId, $currentUserTypeModal) {

                $q->where(function ($q2) use ($currentUserId, $currentUserTypeModal, $userId, $userTypeModal) {
                    $q2->where('sender_id', $currentUserId)
                        ->where('sender_type', $currentUserTypeModal)
                        ->where('receiver_id', $userId)
                        ->where('receiver_type', $userTypeModal);
                })
                    ->orWhere(function ($q2) use ($currentUserId, $currentUserTypeModal, $userId, $userTypeModal) {
                        $q2->where('sender_id', $userId)
                            ->where('sender_type', $userTypeModal)
                            ->where('receiver_id', $currentUserId)
                            ->where('receiver_type', $currentUserTypeModal);
                    });

            })
                ->when(!is_null($currentUserId), function ($query) use ($currentUserId) {
                    $query->where(function ($q) use ($currentUserId) {
                        $q->whereNull('delete_user_id')
                            ->orWhere('delete_user_id', '!=', $currentUserId);
                    });
                })
                ->when(!is_null($currentUserTypeModal), function ($query) use ($currentUserTypeModal) {
                    $query->where(function ($q) use ($currentUserTypeModal) {
                        $q->whereNull('delete_user_type')
                            ->orWhere('delete_user_type', '!=', $currentUserTypeModal);
                    });
                })
                ->latest()
                ->first();

            if (!$user && $userTypeModal) {
                $user = $userTypeModal::find($userId);
            }

            $chatId = !empty($user->chat_id) ? $user->chat_id : Messenger::generateChatId();
            $this->data['user_id'] = $userId;
            $this->data['user_avatar_name'] = Messenger::nameLetters($user->name);
            $this->data['user_name'] = $user->name;
            $this->data['user_type'] = $userType;
            $this->data['message'] = !empty($user->message) ? $user->message : 'Click to start conversation.';
            $this->data['chat_id'] = $chatId;
            $this->data['unseenMessages'] = Message::unseenMessages($user);
            $this->getChatData($chatId);
            $this->data['conversation'] = view('messenger::partials._conversation', $this->data)->render();
        }

        return response()->json(['data' => $this->data]);
    }

    /**
     * Get user conversation
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserConversation(Request $request)
    {
        $data = $request->all();
        if (!empty($data['chat_id'])) {
            $receiverType = !empty($data['receiver_type']) ? $data['receiver_type'] : 'user';
            $model = Messenger::getReceiverModel($receiverType);
            $user = $model::find($data['user_id']);
            $this->data['user_id'] = $data['user_id'];
            $this->data['user_avatar_name'] = Messenger::nameLetters($user->name);
            $this->data['user_name'] = $user->name;
            $this->data['user_type'] = $receiverType;
            $this->data['chat_id'] = $data['chat_id'];
            $this->getChatData($data['chat_id']);
            $this->data['conversation'] = view('messenger::partials._conversation', $this->data)->render();
        }

        return response()->json(['data' => $this->data]);
    }

    /**
     * Get chat data
     *
     * @param $chatId
     * @return array
     */
    private function getChatData($chatId)
    {
        $loginId = Messenger::loginId();
        $loginType = Messenger::loginType();
        $userModel = Messenger::getReceiverModel($loginType);
        $messages = Message::query()
            ->where('chat_id', $chatId)
            ->when(!is_null($loginId), function ($query) use ($loginId) {
                $query->where(function ($q) use ($loginId) {
                    $q->whereNull('delete_user_id')
                        ->orWhere('delete_user_id', '!=', $loginId);
                });
            })
            ->when(!is_null($userModel), function ($query) use ($userModel) {
                $query->where(function ($q) use ($userModel) {
                    $q->whereNull('delete_user_type')
                        ->orWhere('delete_user_type', '!=', $userModel);
                });
            })
            ->orderBy('created_at')
            ->get()
            ->toArray();
        Message::query()->where('chat_id', $chatId)
            ->where('sender_type', '<>', $userModel)
            ->where('sender_id', '<>', $loginId)
            ->update(['is_seen' => 1]);
        $messagesData = [];
        foreach ($messages as $key => $row) {
            $messagesData[$key] = $row;
            $messagesData[$key]['is_send'] = $row['sender_id'] == $loginId ? 1 : 0;
            $messagesData[$key]['message_file'] = !empty($row['file']) ? Messenger::getStoragePath($row['file']) : '';
            $messagesData[$key]['message_time'] = Carbon::parse($row['created_at'])->format('g:i a');
        }
        $this->data['messages'] = $messagesData;

        return $this->data;
    }

    /**
     * Chat users
     *
     * @return mixed
     */
    private function chatUsers()
    {
        return Message::fetchChatUsers();
    }
}
