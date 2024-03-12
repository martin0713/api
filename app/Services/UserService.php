<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function __construct(private UserRepository $repo)
    {
    }

    public function find(string $id): UserResource
    {
        $user = $this->repo->find($id);
        return new UserResource($user);
    }

    public function create(array $validated): \Illuminate\Http\JsonResponse|UserResource
    {
        $user = $this->repo->getUserByEmail($validated['email']);
        if (isset($user)) {
            return response()->json(['message' => 'User already exists'], 422);
        }

        $validated['password'] = password_hash($validated['password'], PASSWORD_BCRYPT);
        $validated['remember_token'] = str_random(60);
        $user = $this->repo->create($validated);
        Auth::login($user);
        return new UserResource($user);
    }

    public function login(array $validated): \Illuminate\Http\JsonResponse|UserResource
    {
        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            $user = Auth::user();
            $user->articles;
            return new UserResource($user);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 422);
        }
    }

    public function logout(): \Illuminate\Http\RedirectResponse
    {
        Auth::logout();
        session()->regenerateToken();
        session()->invalidate();
        return redirect(route('login'));
    }
}
