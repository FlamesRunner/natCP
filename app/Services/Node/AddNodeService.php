<?php

namespace App\Services\Node;


use App\Repositories\Node\NodeRepository;
use App\Traits\SSH;

class AddNodeService
{
    use SSH;
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
     * @return bool
     */
    public function addNode($data)
    {

        if($this->checkLogin($data['hostname'], 'remote', $data['accesskey'])){

            if($this->checkHostExists($data['hostname'])){
                $this->nodeRepository->create($data);
                return true;
            }else{
                return false;
            }

        }else{
            return false;
        }


        // Fire Event
    }

    public function checkHostExists($hostname)
    {
        if($this->nodeRepository->findByHostname($hostname)){
            return true;
        }else{
            return false;
        }
    }
}