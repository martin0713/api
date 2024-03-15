<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Cache;

class CacheRepository
{
    public function __construct(private readonly Cache $model)
    {
    }

    public function getUser($userId)
    {
        return $this->model::get("user:$userId");
    }

    public function setUser($userId, $user)
    {
        return $this->model::put("user:$userId", serialize($user));
    }

    public function deleteUser($userId)
    {
        return $this->model::forget("user:$userId");
    }
};
