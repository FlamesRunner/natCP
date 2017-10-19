<?php

namespace App\Services\User;

use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;

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
     * @param Request $request
     */
    public function addUser(Request $request)
    {
        // Validate data

        $this->userRepository->create($request->all());

        // Fire Event
    }

}