<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth, App\Log;
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
            Log::create([
                'level' => "Info",
                'user_id' => null,
                'action' => "login",
                'table_name' => "Users",
                'description' => "Login success for ".Auth::id(),
            ]);

            $status = "1||Login Success||Welcome to Sripuja Elektronik admin panel!";
    		return redirect()->route('home');
    	}
        Log::create([
            'level' => "Info",
            'user_id' => null,
            'action' => "login",
            'table_name' => "Users",
            'description' => "Login failed. Tried username = $request->username , password = $request->password",
        ]);
        $status = "0||Failed||Invalid Credential!";
    	return redirect()->back()->with("status", $status);
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
