<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Cache;
use App\Models\User;

class CacheRepository
{
    public function __construct(
        private readonly Cache $cacheModel,
        private readonly User $userModel
    ) {
    }

    public function getUser($userId)
    {
        return $this->cacheModel::get("user:$userId");
    }

    public function setUser($userId, $user)
    {
        return $this->cacheModel::put("user:$userId", $user);
    }

    public function deleteUser($userId)
    {
        return $this->cacheModel::forget("user:$userId");
    }

    public function rememberUser($userId)
    {
        return $this->cacheModel::rememberForever("user:$userId", function () use ($userId) {
            return $this->userModel::with(['articles.tags'])->find($userId);
        });
    }
};
