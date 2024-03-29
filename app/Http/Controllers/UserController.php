<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\EmptyResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

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

    public function update(UserUpdateRequest $request): \Illuminate\Http\Response
    {
        $userId = $request->route('userId');
        Gate::authorize('update-user', $userId);
        $validated = $request->validated();
        $data = $this->service->update($validated, $userId);
        return response(new UserResource($data));
    }

    public function destroy(Request $request): \Illuminate\Http\JsonResponse
    {
        $userId = $request->route('userId');
        Gate::authorize('delete-user', $userId);
        $this->service->delete($userId);
        return response()->json(['message' => 'User deleted']);
    }
}
