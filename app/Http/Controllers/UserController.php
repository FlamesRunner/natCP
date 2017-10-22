<?php

namespace App\Http\Controllers;

use App\Services\User\AddUserService;
use App\Services\User\FindUserService;
use App\Services\User\ModifyUserService;
use Illuminate\Http\Request;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{

    /**
     * @var AddUserService
     */
    protected $addUserService;
    /**
     * @var FindUserService
     */
    protected $findUserService;
    /**
     * @var ModifyUserService
     */
    protected $modifyUserService;

    /**
     * UserController constructor.
     * @param AddUserService $addUserService
     * @param FindUserService $findUserService
     * @param ModifyUserService $modifyUserService
     */
    public function __construct(AddUserService $addUserService , FindUserService $findUserService, ModifyUserService $modifyUserService)
    {
        $this->addUserService = $addUserService;
        $this->findUserService = $findUserService;
        $this->modifyUserService = $modifyUserService;
    }

    /**
     * @return $this
     */
    public function index()
    {
        $users = $this->findUserService->all();
        return view('users.index')->with(['users' => $users]);
    }

    /**
     * @param $id
     * @return $this
     */
    public function show($id)
    {
        $user = $this->findUserService->id($id);
        return view('users.show')->with(['user' => $user]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $this->addUserService->addUser($data);

        return redirect('/admin/users');
    }


    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id , Request $request)
    {
        $data = $request->all();

        $this->modifyUserService->update($id,$data);

        return redirect()->back();

    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->modifyUserService->delete($id);
        return redirect('/admin/users')->with(['message' => 'User Successfully Deleted']);
    }
}
