<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    private $model;
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function find(string $id)
    {
        return $this->model->find($id);
    }

    public function create(array $validated)
    {
        return $this->model->create($validated);
    }

    public function getUserByEmail(string $mail)
    {
        return $this->model->where('email', $mail)->first();
    }

    public function updateToken(User $user)
    {
        return $this->model->where('id', $user->id)->update(['remember_token' => $user->remember_token]);
    }
};
