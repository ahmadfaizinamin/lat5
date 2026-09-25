<?php 
namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterfaces;
use Override;

class UserRepository implements UserRepositoryInterfaces
{
    #[Override]
    public function create(array $data)
    {
        return User::create($data);
    }
}