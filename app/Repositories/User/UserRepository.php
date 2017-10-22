<?php


namespace App\Repositories\User;

use App\Repositories\Repository;
use App\Models\User;

class UserRepository extends Repository
{
  public function __construct()
  {
      $this->model = new User();
  }

  public function findByUsername($user_name)
  {
      return $this->model->where('user_name' , $user_name)->first();
  }
}