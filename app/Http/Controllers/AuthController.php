<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function profile()
    {
        $user = Auth::user();
        return view('pages.dashboard.profile', compact('user'));
    }

    public function profile_post(Request $request)
    {
        $user = Auth::user();
        $rules = [];
        $data = [];
        if ($user->name != $request->name) {
            $rules['name'] = 'required|string|min:3|max:100';
            $data['name'] = $request->name;
        }
        if ($user->username != $request->username) {
            $rules['username'] = 'required|string|unique:users,username|min:3|max:100';
            $data['username'] = $request->username;
        }
        if (!is_null($request->password)) {
            $rules['password'] = 'required|string|confirmed|min:3|max:100';
            $data['password'] = Hash::make($request->password);
        }
        $request->validate($rules);

        // 
        $updated = User::find($user->id)->update($data);

        return redirect()->route('profile')->with('message', ['type' => 'success', 'text' => 'Berhasil memperbarui profil.']);
    }
}
