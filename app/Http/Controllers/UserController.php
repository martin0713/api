<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserLoginRequest;

class UserController extends Controller
{
    private $service;
    public function __construct(UserService $userService) {
        $this->service = $userService;
    }

    public function show(string $id) {
        return $this->service->find($id);
    }

    public function store(UserStoreRequest $request) {
        $validated = $request->validated();
        return $this->service->create($validated);
    }

    public function login(UserLoginRequest $request) {
        $validated = $request->validated();
        return $this->service->login($validated);
    }

    public function logout() {
        return $this->service->logout();
    }
}
