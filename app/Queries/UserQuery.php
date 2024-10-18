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

}
