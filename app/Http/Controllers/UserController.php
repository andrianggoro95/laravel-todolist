<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\services\UserService;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(): Response
    {
        return response()->view('user.login', [
            'title' => 'Login'
        ]);
    }

    public function doLogin(Request $request): Response | RedirectResponse
    {
        $user = $request->input('user');
        $password = $request->input('password');
        //validate input
        if (empty($user) || empty($password)) {
            return response()->view('user.login', [
                'title' => 'Login',
                'error' => 'User or password is required'
            ]);
        }

        if ($this->userService->login($user, $password)) {
            $request->session()->put('user', $user);
            return redirect('/');
        }

        return response()->view('user.login', [
            "title" => "login",
            "error" => "Invalid user or password"
        ]);
    }

    public function doLogout(Request $request): RedirectResponse
    {
        $request->session()->forget('user');
        return redirect('/');
    }
}
