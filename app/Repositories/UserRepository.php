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
    /**
     * @param string $id
     * @return User
     */
    public function find(string $id)
    {
        return $this->model->find($id);
    }
    /**
     * @param array $validated
     * @return User
     */
    public function create(array $validated)
    {
        return $this->model->create($validated);
    }
    /**
     * @param string $mail
     * @return User
     */
    public function getUserByEmail(string $mail)
    {
        return $this->model->where('email', $mail)->first();
    }
};
