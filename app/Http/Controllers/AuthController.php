<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;

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

     public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a login request to the application.
     */
    public function register(Request $request)
    {
        $user = new User;
        $user->nama = $request->input('nama');
        $user->tanggal_lahir = $request->input('tanggal_lahir');
        $user->alamat = $request->input('alamat');
        //$user->telepon = $request->input('telepon');
        $user->hp = $request->input('hp');
        $user->tempat_lahir = $request->input('tempatlahir');
        $user->jabatan = $request->input('jabatan');
        $user->username = $request->input('username');
        $user->password = bcrypt($request->input('password'));

        $user->save();

        Auth::login($user);
        return redirect('/');
    }

    /**
     * Handle a logout request to the application.
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
