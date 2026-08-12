<?php

namespace mar\messenger\Contracts;


interface UserResolver
{
    /**
     * Return users available for chat for the logged-in user.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getUsers();
}