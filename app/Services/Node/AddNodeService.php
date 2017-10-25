<?php

namespace App\Services\Node;


use App\Repositories\Node\NodeRepository;

class AddNodeService
{
    protected $nodeRepository;

    /**
     * AddUserService constructor injects instance of the user repository for
     * interaction with model
     *
     * @param NodeRepository $nodeRepository
     */
    public function __construct(NodeRepository $nodeRepository)
    {
        $this->nodeRepository = $nodeRepository;
    }

    /**
     * Add a user to database and fire the user added event
     *
     * @param $data
     */
    public function addNode($data)
    {


        $this->nodeRepository->create($data);

        // Fire Event
    }
}