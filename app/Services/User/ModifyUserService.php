<?php


namespace App\Services\User;


use App\Repositories\User\UserRepository;

class ModifyUserService
{

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function delete($id)
    {
        return $this->userRepository->delete($id);
    }

    public function update($id, $data)
    {
        return $this->userRepository->update($id, $data);
    }

}