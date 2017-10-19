<?php


namespace App\Services\User;
use App\Repositories\User\UserRepository;

class FindUserService
{

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function all()
    {
        return $this->userRepository->all();
    }

}