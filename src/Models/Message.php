<?php

namespace mar\messenger\Models;

use mar\messenger\Helpers\Messenger;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Message extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Fetch chat users
     *
     * @return mixed
     */
    protected static function fetchChatUsers($receiverId = '', $receiverType = '')
    {
        $userId = !empty($receiverId) ? $receiverId : Messenger::loginId();
        $userType = !empty($receiverType) ? $receiverType : Messenger::loginType();
        $userModel = Messenger::getReceiverModel($userType);

        $messages = Message::query()->where(function ($q) use ($userId, $userModel) {

            $q->where(function ($q2) use ($userId, $userModel) {
                $q2->where('sender_id', $userId)
                    ->where('sender_type', $userModel);
            })

                ->orWhere(function ($q2) use ($userId, $userModel) {
                    $q2->where('receiver_id', $userId)
                        ->where('receiver_type', $userModel);
                });

        })
            ->latest()
            ->get()
            ->unique('chat_id');

        $chats = [];

        foreach ($messages as $message) {
            $type = '';
            if ($message->sender_id == $userId && $message->sender_type == $userModel) {
                $id = $message->receiver_id;
                $type = $message->receiver_type;
            } else {
                $id = $message->sender_id;
                $type = $message->sender_type;
            }

            $typeName = Messenger::getTypeFromModel($type);

            if (!$type) {
                continue;
            }

            $user = $type::find($id);

            if (!$user) {
                continue;
            }

            $chats[] = [
                'chat_id' => $message->chat_id,
                'id' => $user->id,
                'name' => $user->name,
                'user_type' => $typeName,
                'message' => $message->message,
                'file' => $message->file,
                'created_at' => $message->created_at,
            ];
        }

        return $chats;
    }

    /**
     * Unseen messages
     *
     * @param $userId
     * @return
     */
    protected static function unseenMessages($userId)
    {
        return Message::where('receiver_id', Messenger::loginId())->where('sender_id', $userId)->where('is_seen', 0)->count();
    }

    public function sender()
    {
        return $this->morphTo();
    }

    public function receiver()
    {
        return $this->morphTo();
    }
}
