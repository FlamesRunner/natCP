<?php

namespace App\Http\Controllers;

use App\Services\Node\AddNodeService;
use App\Services\Node\FindNodeService;
use App\Services\Node\ManageNodeService;
use Illuminate\Http\Request;

class NodeController extends Controller
{
    public function index(FindNodeService $findNodeService)
    {
        $nodes = $findNodeService->all();
        return view('nodes.index')->with(['nodes' => $nodes]);
    }

    /**
     * @param $id
     * @param FindNodeService $findNodeService
     * @return $this
     */
    public function show($id, FindNodeService $findNodeService)
    {
        $node = $findNodeService->id($id);
        return view('nodes.show')->with(['node' => $node]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('nodes.create');
    }

    /**
     * @param Request $request
     * @param AddNodeService $addNodeService
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, AddNodeService $addNodeService)
    {
        $data = $request->all();

        $addNodeService->addNode($data);

        return redirect('/admin/nodes');
    }


    /**
     * @param $id
     * @param Request $request
     * @param ManageNodeService $manageNodeService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id , Request $request, ManageNodeService $manageNodeService)
    {
        $data = $request->all();

        $manageNodeService->update($id,$data);

        return redirect()->back();

    }

    /**
     * @param $id
     * @param ManageNodeService $manageNodeService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id, ManageNodeService $manageNodeService)
    {
        $manageNodeService->delete($id);
        return redirect('/admin/nodes')->with(['message' => 'User Successfully Deleted']);
    }

}
