<?php

namespace mar\messenger\Services;


use mar\messenger\Helpers\Messenger;
use mar\messenger\Contracts\UserResolver;

class DefaultUserResolver implements UserResolver
{
    public function getUsers()
    {
        $users = [];

        $currentUserId = Messenger::loginId();
        $currentUserType = Messenger::loginType();

        foreach (config('messenger.models') as $type => $model) {

            $query = $model::query();

            // Exclude current user only from its own model
            if ($type === $currentUserType) {
                $query->where('id', '!=', $currentUserId);
            }

            $modelUsers = $query->get()->map(function ($user) use ($type) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'user_type' => $type,
                ];
            })->toArray();

            $users = array_merge($users, $modelUsers);
        }

        return $users;
    }
}