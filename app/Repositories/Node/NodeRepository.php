<?php


namespace App\Repositories\Node;

use App\Repositories\Repository;
use App\Models\Node;

class NodeRepository extends Repository
{
  public function __construct()
  {
      $this->model = new Node();
  }

}