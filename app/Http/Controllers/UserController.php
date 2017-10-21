<?php

namespace App\Http\Controllers;

use App\Services\User\AddUserService;
use App\Services\User\FindUserService;
use Illuminate\Http\Request;

class UserController extends Controller
{

    protected $addUserService;
    protected $findUserService;

    public function __construct(AddUserService $addUserService , FindUserService $findUserService)
    {
        $this->addUserService = $addUserService;
        $this->findUserService = $findUserService;
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


    public function update(Request $request)
    {
        $this->findUserService
    }
}
