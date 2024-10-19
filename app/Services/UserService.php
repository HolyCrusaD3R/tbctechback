<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Product;
use App\Models\User;
use App\Queries\ProductQuery;
use App\Queries\UserQuery;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class UserService
{
    private UserQuery $userQuery;

    /**
     * @param UserQuery $userQuery
     */
    public function __construct(UserQuery $userQuery)
    {
        $this->userQuery = $userQuery;
    }


    /**
     * @return User|null
     */
    public function getUserInfo(): ?User
    {
        $userId = Auth::id();
        return $this->userQuery->getUserById(id: $userId);
    }
}
