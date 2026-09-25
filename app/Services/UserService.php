<?php
namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterfaces;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class UserService
{
    protected $auth;
    protected $userRepo;

    public function __construct(UserRepositoryInterfaces $userRepo)
    {
        $this->userRepo = $userRepo;
        $this->auth = Auth::guard('api');
    }

    public function registerUser(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $user = $this->userRepo->create($data);

        $token = JWTAuth::fromUser($user);

        return [
            'user' => $user,
            'token' => $token,
            'expires_in' => config('jwt.ttl') * 60
        ];
    }

    public function loginUser(array $data)
    {
        $token = $this->auth->attempt($data);

        $user = $this->auth->user();

        return [
            'user' => $user,
            'token' => $token,
            'expires_in' => config('jwt.ttl') * 60
        ];
    }

    public function logoutUser()
    {
        $this->auth->logout();
    }

    public function refreshUserToken()
    {
        $token = JWTAuth::parseToken()->refresh();

        return [
            'token' => $token,
            'expires_in' => config('jwt.ttl') * 60
        ];
    }
}