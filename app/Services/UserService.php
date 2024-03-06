<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService{
    private $repo;
    public function __construct(UserRepository $repo) {
        $this->repo = $repo;
    }

    public function find(string $id) {
        $user = $this->repo->find($id);
        $user->articles;
        return $user;
    }
};
