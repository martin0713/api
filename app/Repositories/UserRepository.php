<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    private User $model;
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function find(string $id): User
    {
        return $this->model->find($id);
    }

    public function create(array $validated): User
    {
        return $this->model->create($validated);
    }

    public function getUserByEmail(string $mail): User|NULL
    {
        return $this->model->where('email', $mail)->first();
    }
}
