<?php

namespace App\Services\Node;

use App\Repositories\Node\NodeRepository;

class FindNodeService
{
    protected $nodeRepository;

    public function __construct(NodeRepository $nodeRepository)
    {
        $this->nodeRepository = $nodeRepository;
    }

    public function all()
    {
        return $this->nodeRepository->all();
    }

    public function id($id)
    {
        return $this->nodeRepository->find($id);
    }
}