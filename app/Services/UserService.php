<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Redis;

class UserService
{
    public function __construct(private readonly UserRepository $repo)
    {
    }

    public function find(string $id): User |null
    {
        $user = Redis::get("user:$id");
        if ($user === null) {
            $user = $this->repo->find($id);
            if ($user === null) {
                throw new HttpResponseException(response()->json(['message' => 'User not found'], 404));
            }
            Redis::set("user:$id", serialize($user));
            return $user;
        }
        $user = unserialize($user);
        return $user;
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
        Redis::set("user:$user->id", serialize($user));
        return $user;
    }

    public function login(array $validated): \Illuminate\Http\JsonResponse |User
    {
        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            $user = Auth::user();
            Redis::set("user:$user->id", serialize($user));
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

    public function update(array $validated, string $userId): \Illuminate\Http\JsonResponse |User
    {
        $result = $this->repo->update($validated, $userId);
        if ($result) {
            $user = Auth::user()->refresh();
            Auth::login($user);
            Redis::set("user:$userId", serialize($user));
            return $user;
        }
        throw new HttpResponseException(response()->json(['message' => 'Fail to update']));
    }

    public function delete(string $userId): string
    {
        $result = $this->repo->delete($userId);
        if ($result) {
            Redis::del("user:$userId");
            return true;
        }
        return false;
    }
}
