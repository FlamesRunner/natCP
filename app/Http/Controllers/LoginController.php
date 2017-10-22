<?php

namespace App\Http\Controllers;

use App\Services\User\LoginService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $loginService;

    /**
     * Create a new controller instance.
     *
     * @param LoginService $loginService
     */
    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return $this->loginService->showLoginForm();
    }

    public function login(Request $request)
    {
        return $this->loginService->login($request);
    }

    public function logout(Request $request)
    {
        return $this->loginService->logout($request);
    }
}
