<?php

namespace App\Providers;

use App\Models\User;
use http\Exception\RuntimeException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class CustomUserServiceProvider implements UserProvider
{
    public function retrieveByToken($identifier, $token)
    {
        throw new RuntimeException('Method not implemented.');
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        throw new RuntimeException('Method not implemented.');
    }

    public function retrieveById($identifier)
    {
        return $this->getMemberInstance($identifier);
    }

    public function retrieveByCredentials(array $credentials)
    {
        return $this->getMemberInstance($credentials['email']);
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return true;
    }

    private function getMemberInstance($email)
    {
        return tap(new User(), function ($user) use ($email) {
            $user->email = (string) $email;
        });
    }
}
