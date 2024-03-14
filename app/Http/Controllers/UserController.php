<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\EmptyResource;

class UserController extends Controller
{
    public function __construct(private readonly UserService $service)
    {
    }
    /**
     * Display a listing of the resource.
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $data = $this->service->find($id);
        if ($data === null) {
            return (new EmptyResource($data))->response();
        }
        return UserResource::make($data)->response();
    }

    public function store(UserStoreRequest $request): \Illuminate\Http\Response
    {
        $validated = $request->validated();
        $data = $this->service->create($validated);
        return response(new UserResource($data), 201);
    }

    public function login(UserLoginRequest $request): \Illuminate\Http\Response
    {
        $validated = $request->validated();
        $data = $this->service->login($validated);
        return response(new UserResource($data));
    }

    public function logout(): \Illuminate\Http\RedirectResponse
    {
        return $this->service->logout();
    }

    public function update(UserUpdateRequest $request, string $id): \Illuminate\Http\Response
    {
        $validated = $request->validated();
        $data = $this->service->update($validated, $id);
        return response(new UserResource($data));
    }

    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        $result = $this->service->delete($id);
        if ($result) {
            return response()->json(['message' => 'User deleted']);
        }
        return response()->json(['message' => 'Fail to delete']);
    }
}
