<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class AuthController extends Controller
{
    //

    public function showLogin()
    {
    	return view('auth.login');
    }

    public function login(Request $request)
    {
    	if(Auth::attempt([
    		'username' => $request->username,
    		'password' => $request->password
    		]))
    	{
    		return redirect()->route('home');
    	}
    	return "failed";
    }

    public function showLock()
    {

    }

    public function lock()
    {

    }

    public function logout()
    {
    	Auth::logout();
    	return redirect()->route('login');
    }
}
