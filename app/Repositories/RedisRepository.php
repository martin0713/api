<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Redis;

class RedisRepository
{
    public function __construct(private readonly Redis $model)
    {
    }

    public function getUser($userId)
    {
        return $this->model::get("user:$userId");
    }

    public function setUser($userId, $user)
    {
        return $this->model::set("user:$userId", serialize($user));
    }

    public function deleteUser($userId)
    {
        return $this->model::del("user:$userId");
    }
};
