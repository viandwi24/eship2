<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Route;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RouteController extends Controller
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
            $eloquent = Route::query();
            return DataTables::of($eloquent)
                ->make(true);
        }
        return view('pages.dashboard.route.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dashboard.route.create');
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
            'departure' => 'required|string|min:3|max:250',
            'arrival' => 'required|string|min:3|max:250',
        ]);

        // 
        $data = $request->all();

        // 
        $created = Route::create($data);

        return redirect()->route('routes.index')->with('message', ['type' => 'success', 'text' => 'Berhasil menambahkan rute baru.']);
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
    public function edit(Route $route)
    {
        return view('pages.dashboard.route.edit', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Route $route)
    {
        $rules = [];
        $data = [];
        if ($route->departure != $request->departure) {
            $rules['departure'] = 'required|string|min:3|max:250';
            $data['departure'] = $request->departure;
        }
        if ($route->arrival != $request->arrival) {
            $rules['arrival'] = 'required|string|min:3|max:250';
            $data['arrival'] = $request->arrival;
        }
        $request->validate($rules);

        // 
        $updated = $route->update($data);

        return redirect()->route('routes.index')->with('message', ['type' => 'success', 'text' => 'Berhasil memperbarui data.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Route $route)
    {
        $deleted = $route->delete();
        return redirect()->route('routes.index')->with('message', ['type' => 'success', 'text' => 'Berhasil menghapus rute.']);
    }
}
