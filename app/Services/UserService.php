<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserService
{
    public function __construct(private readonly UserRepository $repo)
    {
    }

    public function find(string $id): User |null
    {
        return $this->repo->find($id);
    }

    public function create(array $validated): \Illuminate\Http\JsonResponse |User
    {
        $user = $this->repo->getUserByEmail($validated['email']);
        if (isset($user)) {
            throw new HttpResponseException(response()->json(['message' => 'User already exists'], 422));
        }

        $validated['password'] = password_hash($validated['password'], PASSWORD_BCRYPT);
        $validated['remember_token'] = str_random(60);
        $user = $this->repo->create($validated);
        Auth::login($user);
        return $user;
    }

    public function login(array $validated): \Illuminate\Http\JsonResponse |User
    {
        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            $user = Auth::user();
            return $user;
        } else {
            throw new HttpResponseException(response()->json(['message' => 'Invalid credentials'], 422));
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
