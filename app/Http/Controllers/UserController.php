<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function __construct(private UserService $service)
    {
    }
    /**
     * Display a listing of the resource.
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        $data = $this->service->find($id);
        if ($data) return response(new UserResource($data));
        else return response('Not Found', 404);
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
        $data = $this->service->create($validated);
        return response(new UserResource($data), 201);
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
        $data = $this->service->login($validated);
        return response(new UserResource($data), 201);
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
