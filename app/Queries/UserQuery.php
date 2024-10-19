<?php

namespace App\Queries;


use App\Models\User;

class UserQuery
{

    /**
     * @param int $id
     * @param int $balance
     * @return mixed
     */
    public function updateBalanceById(int $id, int $balance): mixed
    {
        return User::query()
            ->where('id', $id)
            ->update([
                'balance' => $balance
            ]);
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
