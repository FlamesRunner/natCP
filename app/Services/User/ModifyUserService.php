<?php


namespace App\Services\User;


use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;

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

        if(isset($data['password'])){
            $data['user_password_hash'] = Hash::make($data['password']);
            unset($data['password']);
        }

        return $this->userRepository->update($id, $data);
    }

}