<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\RedisRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserService
{

    public function __construct(
        private readonly UserRepository $userRepo,
        private readonly RedisRepository $redisRepo
    ) {
    }

    public function find(string $id): User |null
    {
        $user = $this->redisRepo->getUser($id);
        if ($user === null) {
            $user = $this->userRepo->find($id);
            if ($user === null) {
                throw new HttpResponseException(response()->json(['message' => 'User not found'], 404));
            }
            $this->redisRepo->setUser($id, $user);
            return $user;
        }
        return unserialize($user);
    }

    public function create(array $validated): \Illuminate\Http\JsonResponse |User
    {
        $user = $this->userRepo->getUserByEmail($validated['email']);
        if (isset($user)) {
            throw new HttpResponseException(response()->json(['message' => 'User already exists'], 422));
        }

        $validated['password'] = password_hash($validated['password'], PASSWORD_BCRYPT);
        $user = $this->userRepo->create($validated);
        Auth::login($user);
        $this->redisRepo->setUser($user->id, $user);
        return $user;
    }

    public function login(array $validated): \Illuminate\Http\JsonResponse |User
    {
        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            $user = Auth::user();
            $this->redisRepo->setUser($user->id, $user);
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
        $result = $this->userRepo->update($validated, $userId);
        if ($result) {
            $user = Auth::user()->refresh();
            Auth::login($user);
            $this->redisRepo->setUser($userId, $user);
            return $user;
        }
        throw new HttpResponseException(response()->json(['message' => 'Fail to update']));
    }

    public function delete(string $userId): string
    {
        $result = $this->userRepo->delete($userId);
        if ($result) {
            $this->redisRepo->deleteUser($userId);
            return true;
        }
        return false;
    }
}
