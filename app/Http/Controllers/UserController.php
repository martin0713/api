<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{
    private $service;
    public function __construct(UserService $userService) {
        $this->service = $userService;
    }

    public function show(string $id) {
        return $this->service->find($id);
    }
}
