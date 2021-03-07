<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $eloquent = User::whereNotIn('id', [Auth::user()->id]);
            return DataTables::of($eloquent)
                ->make(true);
        }
        return view('pages.dashboard.account.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dashboard.account.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users,username|min:3|max:100',
            'name' => 'required|string|min:3|max:100',
            'password' => 'required|string|confirmed|min:3|max:100',
            'role' => 'required|in:Admin,Petugas,Super Duper Admin,Supervisor'
        ]);

        // 
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);

        // 
        $created = User::create($data);

        return redirect()->route('users.index')->with('message', ['type' => 'success', 'text' => 'Berhasil menambahkan akun baru.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('pages.dashboard.account.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules = [];
        $data = [];
        if ($user->role != $request->role) {
            $rules['role'] = 'required|in:Admin,Petugas,Super Duper Admin,Supervisor';
            $data['role'] = $request->username;
        }
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
        $updated = $user->update($data);

        return redirect()->route('users.index')->with('message', ['type' => 'success', 'text' => 'Berhasil memperbarui akun.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $deleted = $user->delete();
        return redirect()->route('users.index')->with('message', ['type' => 'success', 'text' => 'Berhasil menghapus akun.']);
    }
}
