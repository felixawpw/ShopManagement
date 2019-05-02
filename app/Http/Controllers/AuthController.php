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
                'user_id' => Auth::id(),
                'action' => "login",
                'table_name' => "Users",
                'description' => "Login success for ".Auth::id(),
            ]);

            $status = "1||Login Berhasil||Selamat datang di panel admin Sripuja Elektronik!";
    		return redirect()->route('home')->with('status', $status);
    	}
        Log::create([
            'level' => "Info",
            'user_id' => null,
            'action' => "login",
            'table_name' => "Users",
            'description' => "Login failed. Tried username = $request->username , password = $request->password",
        ]);
        $status = "0||Login Gagal||Username atau password yang anda masukkan salah!";
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
