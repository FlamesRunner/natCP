<?php

namespace App\Http\Controllers;

use App\Services\User\AddUserService;
use App\Services\User\FindUserService;
use App\Services\User\ModifyUserService;
use Illuminate\Http\Request;

class UserController extends Controller
{

    protected $addUserService;
    protected $findUserService;
    protected $modifyUserService;

    public function __construct(AddUserService $addUserService , FindUserService $findUserService, ModifyUserService $modifyUserService)
    {
        $this->addUserService = $addUserService;
        $this->findUserService = $findUserService;
        $this->modifyUserService = $modifyUserService;
    }

    public function index()
    {
        $users = $this->findUserService->all();
        return view('users.index')->with(['users' => $users]);
    }

    public function show($id)
    {
        $user = $this->findUserService->id($id);
        return view('users.show')->with(['user' => $user]);
    }

    public function store(Request $request)
    {

    }




    public function update($id , Request $request)
    {
        $data = $request->all();


        if($data['password']){
            $this->modifyUserService->changePassword($data);
            return redirect()->back()->withErrors(['msg', 'Passwords do not match']);
        }



        $this->modifyUserService->update($id,$data);


    }
}
