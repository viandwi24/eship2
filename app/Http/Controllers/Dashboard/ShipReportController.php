<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Ship;
use App\Models\ShipReport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ShipReportController extends Controller
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
            $eloquent = ShipReport::with('ship', 'user', 'route');
            return DataTables::of($eloquent)
                ->editColumn('date', function ($q) { return date('d-m-Y', strtotime($q->date)); })
                ->editColumn('time', function ($q) { return date('H:i', strtotime($q->time)); })
                ->make(true);
        }
        return view('pages.dashboard.ship-reports.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ships = Ship::all();
        $petugas_users = User::where('role', 'Petugas')->get();
        $routes = Route::all();
        return view('pages.dashboard.ship-reports.create', compact('ships', 'petugas_users', 'routes'));
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
            'user_id' => 'required|numeric',
            'ship_id' => 'required|numeric',
            'route_id' => 'required|numeric',
            'date' => 'required|date',
            'time' => 'required',
            'count_adult' => 'required|numeric|min:0',
            'count_baby' => 'required|numeric|min:0',
            'count_security_forces' => 'required|numeric|min:0',
            'count_vehicle_wheel_2' => 'required|numeric|min:0',
            'count_vehicle_wheel_4' => 'required|numeric|min:0',
        ]);

        // 
        $data = $request->all();
        $data['date'] = Carbon::parse($request->date);
        $data['time'] = Carbon::parse($request->time)->format('H:i');

        // 
        $created = ShipReport::create($data);

        return redirect()->route('ship-reports.index')->with('message', ['type' => 'success', 'text' => 'Berhasil menambahkan data baru.']);
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
    public function edit(ShipReport $shipReport)
    {
        $ships = Ship::all();
        $petugas_users = User::where('role', 'Petugas')->get();
        $routes = Route::all();
        return view('pages.dashboard.ship-reports.edit', compact('ships', 'petugas_users', 'routes', 'shipReport'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShipReport $shipReport)
    {
        $request->validate([
            'user_id' => 'required|numeric',
            'ship_id' => 'required|numeric',
            'route_id' => 'required|numeric',
            'date' => 'required|date',
            'time' => 'required',
            'count_adult' => 'required|numeric|min:0',
            'count_baby' => 'required|numeric|min:0',
            'count_security_forces' => 'required|numeric|min:0',
            'count_vehicle_wheel_2' => 'required|numeric|min:0',
            'count_vehicle_wheel_4' => 'required|numeric|min:0',
        ]);

        // 
        $data = $request->all();
        $data['date'] = Carbon::parse($request->date);
        $data['time'] = Carbon::parse($request->time)->format('H:i');

        // 
        $created = $shipReport->update($data);

        return redirect()->route('ship-reports.index')->with('message', ['type' => 'success', 'text' => 'Berhasil memperbarui data baru.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShipReport $shipReport)
    {
        $deleted = $shipReport->delete();
        return redirect()->route('ship-reports.index')->with('message', ['type' => 'success', 'text' => 'Berhasil menghapus data.']);
    }
}
