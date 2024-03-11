<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class UserService
{
    private $repo;
    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }

    public function find(string $id)
    {
        $user = $this->repo->find($id);
        $user->articles;
        return new UserResource($user);
    }

    public function create($validated)
    {
        $user = $this->repo->getUserByEmail($validated['email']);
        if (isset($user)) {
            return response()->json([ 'message' => 'User already exists'], 422);
        }

        $validated['password'] = password_hash($validated['password'], PASSWORD_BCRYPT);
        $validated['remember_token'] = str_random(60);
        $user = $this->repo->create($validated);
        Auth::login($user);
        return new UserResource($user);
    }

    public function login($validated)
    {
        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            $user = Auth::user();
            $user->articles;
            return new UserResource($user);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 422);
        }
    }

    public function logout()
    {
        Auth::logout();
        session()->regenerateToken();
        session()->invalidate();
        return redirect(route('login'));
    }
};
