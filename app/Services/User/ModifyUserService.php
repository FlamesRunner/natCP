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

    public function changePassword($password,$re_password)
    {
        // validate passwords or remove if blank
        if($data['password'] and ($data['password'] != $data['re_password'])){
            return false;
        }
    }



    public function update($id, $data)
    {

        unset($data['password']);
        unset($data['re_password']);

        return $this->userRepository->update($id, $data);
    }

}