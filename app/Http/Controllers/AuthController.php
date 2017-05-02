<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     */
    public function login(Request $request)
    {
        Auth::attempt($request->input());
        echo json_encode(['status' => Auth::check()]);
    }

    /**
     * Handle a logout request to the application.
     */
    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
