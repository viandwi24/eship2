<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('pages.auth.login');
    }

    public function login_post(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3',
            'password' => 'required|string|min:3',
        ]);

        $check = Auth::attempt(['username' => $request->username, 'password' => $request->password]);
        if ($check) return redirect()->route('dashboard');
        return redirect()->route('login')->withInput(['username'])->with('message', ['type' => 'danger', 'text' => 'Kredensial tidak sesuai dengan akun manapun.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
