<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;


Class AuthService
{
    private User $user;

    public function __construct(User $user){
        $this->user = $user;
    }


    /**
     * @param array $data
     * @return User
     * @throws Exception
     */
    public function register(array $data): User
    {
        try {
            $data['password'] = bcrypt($data['password']);
            $user = $this->user->create($data);
            event(new Registered($user));
            return $user;
        } catch (Exception $exception){
            throw new Exception($exception->getMessage() .'User can not be registered at the moment');
            //throw new Exception('User can not be registered at the moment');
        }
    }
}
