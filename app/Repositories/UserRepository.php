<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository{
    private $model;
    public function __construct(User $model) {
        $this->model = $model;
    }

    public function find(string $id) {
        return $this->model->find($id);
    }
};
