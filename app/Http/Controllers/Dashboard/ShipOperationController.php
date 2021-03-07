<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Ship;
use App\Models\ShipOperation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ShipOperationController extends Controller
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
            $eloquent = ShipOperation::with('ship');
            return DataTables::of($eloquent)
                ->editColumn('date', function ($q) { return date('d-m-Y', strtotime($q->date)); })
                ->make(true);
        }
        return view('pages.dashboard.ship-operations.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ships = Ship::all();
        return view('pages.dashboard.ship-operations.create', compact('ships'));
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
            'ship_id' => 'required|numeric',
            'date' => 'required|date',
            'status' => 'required|in:Beroperasi,Tidak Beroperasi',
            'description' => 'required|in:Aman,Cuaca Buruk,Perbaikan Mesin,Docking',
            'location' => 'required|string|min:3|max:250',
        ]);

        // 
        $data = $request->all();
        $data['date'] = Carbon::parse($request->date);

        // 
        $created = ShipOperation::create($data);

        return redirect()->route('ship-operations.index')->with('message', ['type' => 'success', 'text' => 'Berhasil menambahkan data baru.']);
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
    public function edit(ShipOperation $shipOperation)
    {
        $ships = Ship::all();
        return view('pages.dashboard.ship-operations.edit', compact('shipOperation', 'ships'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShipOperation $shipOperation)
    {
        $rules = [];
        $data = [];
        if ($shipOperation->ship_id != $request->ship_id) {
            $rules['ship_id'] = 'required|numeric';
            $data['ship_id'] = $request->ship_id;
        }
        if ($shipOperation->date != $request->date) {
            $rules['date'] = 'required|date';
            $data['date'] = $request->date;
        }
        if ($shipOperation->status != $request->status) {
            $rules['status'] = 'required|in:Beroperasi,Tidak Beroperasi';
            $data['status'] = $request->status;
        }
        if ($shipOperation->description != $request->description) {
            $rules['description'] = 'required|in:Aman,Cuaca Buruk,Perbaikan Mesin,Docking';
            $data['description'] = $request->description;
        }
        if ($shipOperation->location != $request->location) {
            $rules['location'] = 'required|string|min:3|max:250';
            $data['location'] = $request->location;
        }
        $request->validate($rules);

        // 
        $updated = $shipOperation->update($data);

        return redirect()->route('ship-operations.index')->with('message', ['type' => 'success', 'text' => 'Berhasil memperbarui data.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShipOperation $shipOperation)
    {
        $deleted = $shipOperation->delete();
        return redirect()->route('ship-operations.index')->with('message', ['type' => 'success', 'text' => 'Berhasil menghapus data.']);
    }
}
