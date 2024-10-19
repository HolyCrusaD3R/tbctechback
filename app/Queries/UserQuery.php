<?php

namespace App\Queries;


use App\Models\User;

class UserQuery
{

    /**
     * @param $email
     * @return mixed
     */
    public function getUserByEmail($email): mixed
    {
        return User::query()
            ->where('email', $email)
            ->first();
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function getUserById(int $id): ?User
    {
        return User::query()
            ->where('id', $id)
            ->first();
    }

}
