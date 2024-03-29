<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function __construct(private readonly User $model)
    {
    }

    public function find(string $id): User |null
    {
        return $this->model::with(['articles.tags'])->find($id);
    }

    public function create(array $validated): User
    {
        return $this->model->create($validated);
    }

    public function getUserByEmail(string $mail): User |null
    {
        return $this->model->where('email', $mail)->first();
    }

    public function update(array $validated, string $id): int
    {
        return $this->model->find($id)->update($validated);
    }

    public function delete(string $id): int
    {
        return $this->model->find($id)->delete();
    }
}
