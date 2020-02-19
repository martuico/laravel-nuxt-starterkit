<?php


namespace App\BunkerMaestro\UserManagement\Actions;

use App\User;

class GetUserById
{
    public function handle(int $id)
    {
        return User::findOrFail($id);
    }
}
