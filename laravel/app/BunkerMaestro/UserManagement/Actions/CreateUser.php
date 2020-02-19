<?php


namespace App\BunkerMaestro\UserManagement\Actions;


use App\User;
use Illuminate\Support\Facades\Hash;

class CreateUser
{
    public function handle(string $name, string $email, string $password = null)
    {
        $password = Hash::make($password);
        if ($password === null) {
            $password = 'no-password';
        }
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);
    }
}
