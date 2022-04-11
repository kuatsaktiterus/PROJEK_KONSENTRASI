<?php

namespace App\Services;

use App\Models\User;

class CreateUserService {
    public function CreateUser($request)
    {
        try {
            $user = User::create([
                'username' => $request['username'],
                'password' => $request['password'],
                'role'     => $request['role'],
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }

        return $user;
    }
}