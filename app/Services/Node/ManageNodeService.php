<?php

namespace App\Services\Node;

use App\Repositories\Node\NodeRepository;
use App\Traits\SSH;

class ManageNodeService
{
    use SSH;
    protected $nodeRepository;

    public function __construct(NodeRepository $nodeRepository)
    {
        $this->nodeRepository = $nodeRepository;
    }

    public function delete($id)
    {
        return $this->nodeRepository->delete($id);
    }


    public function update($id, $data)
    {
        return $this->nodeRepository->update($id, $data);
    }

}