<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Ship;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ShipController extends Controller
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
            $eloquent = Ship::query();
            return DataTables::of($eloquent)
                ->editColumn('date', function ($q) { return date('d-m-Y', strtotime($q->date)); })
                ->make(true);
        }
        return view('pages.dashboard.ship.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dashboard.ship.create');
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
            'name' => 'required|string|min:3|max:250',
        ]);

        // 
        $data = $request->all();

        // 
        $created = Ship::create($data);

        return redirect()->route('ships.index')->with('message', ['type' => 'success', 'text' => 'Berhasil menambahkan kapal baru.']);
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
    public function edit(Ship $ship)
    {
        return view('pages.dashboard.ship.edit', compact('ship'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ship $ship)
    {
        $rules = [];
        $data = [];
        if ($ship->name != $request->name) {
            $rules['name'] = 'required|string|min:3|max:250';
            $data['name'] = $request->name;
        }
        $request->validate($rules);

        // 
        $updated = $ship->update($data);

        return redirect()->route('ships.index')->with('message', ['type' => 'success', 'text' => 'Berhasil memperbarui data.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ship $ship)
    {
        $deleted = $ship->delete();
        return redirect()->route('ships.index')->with('message', ['type' => 'success', 'text' => 'Berhasil menghapus kapal.']);
    }
}
