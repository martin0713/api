<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function show(string $id) {
        $user = User::find($id);
        $user->articles;
        return $user;
    }
}
