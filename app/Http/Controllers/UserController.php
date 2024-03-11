<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserLoginRequest;

class UserController extends Controller
{
    private $service;
    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }
    /**
     * Display a listing of the resource.
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        return $this->service->find($id);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $validated = $request->validated();
        return $this->service->create($validated);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(UserLoginRequest $request)
    {
        $validated = $request->validated();
        return $this->service->login($validated);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        return $this->service->logout();
    }
}
