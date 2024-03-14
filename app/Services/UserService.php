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

    public function update(array $validated, string $id): \Illuminate\Http\JsonResponse |User
    {
        $userId = Auth::id();
        if ($userId != $id) {
            throw new HttpResponseException(response()->json(['message' => "You don't have permission to update. User(user id:$userId) can't update user$id."], 422));
        }
        $result = $this->repo->update($validated, $id);
        if ($result) {
            $user = Auth::user()->refresh();
            Auth::login($user);
            return $user;
        }
        throw new HttpResponseException(response()->json(['message' => 'Fail to update']));
    }
}
