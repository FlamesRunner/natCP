<?php

namespace App\Services\User;

use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Class AddUserService exclusively handles the adding of a new user
 * @package App\Services\User
 */
class AddUserService
{
    protected $userRepository;

    /**
     * AddUserService constructor injects instance of the user repository for
     * interaction with model
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Add a user to database and fire the user added event
     *
     * @param $data
     */
    public function addUser($data)
    {

        if(isset($data['password'])){
            $data['user_password_hash'] = Hash::make($data['password']);
            unset($data['password']);
        }

        $data['permission_level'] = 'member';

        $this->userRepository->create($data);

        // Fire Event
    }

}