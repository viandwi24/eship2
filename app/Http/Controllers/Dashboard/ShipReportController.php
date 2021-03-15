<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Ship;
use App\Models\ShipOperation;
use App\Models\ShipReport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class ShipReportController extends Controller
{
    public $folder = 'app/data_laporan/';
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
        $allowed_ships = ShipOperation::whereDate('date', Carbon::parse(Carbon::now())->toDateString())->get()->pluck('ship_id');
        $ships = Ship::whereIn('id', $allowed_ships)->get();
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
        $rules = [
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
        ];
        if ($request->hasFile('photo_embarkation')) $rules['photo_embarkation'] = 'required|file|mimes:png,jpeg,jpg,bmp';
        if ($request->hasFile('photo_departure')) $rules['photo_departure'] = 'required|file|mimes:png,jpeg,jpg,bmp';
        $request->validate($rules);

        // checking 
        $tmp = ShipReport::whereDate('date', Carbon::parse(Carbon::now())->toDateString())->where('ship_id', $request->ship_id)->get();
        if (count($tmp) > 0)
        {
            return redirect()->route('ship-reports.index')->with('message', ['type' => 'danger', 'text' => 'Kapal yang anda pilih hari ini telah memiliki laporan.']);
        }

        // 
        $data = $request->all();
        $data['date'] = Carbon::parse($request->date);
        $data['time'] = Carbon::parse($request->time)->format('H:i');

        DB::transaction(function () use ($request, $data) {
            // 
            if ($request->hasFile('photo_embarkation'))
            {
                $file_photo_embarkation = $request->photo_embarkation;
                $file_photo_embarkation_name = Str::random(200) . '.' . $file_photo_embarkation->getClientOriginalExtension();
                $file_photo_embarkation->storeAs('data_laporan', $file_photo_embarkation_name);
                $data['photo_embarkation'] = $file_photo_embarkation_name;
            }

            // 
            if ($request->hasFile('photo_departure'))
            {
                $file_photo_departure = $request->photo_departure;
                $file_photo_departure_name = Str::random(200) . '.' . $file_photo_departure->getClientOriginalExtension();
                $file_photo_departure->storeAs('data_laporan', $file_photo_departure_name);
                $data['photo_departure'] = $file_photo_departure_name;
            }

            // 
            $created = ShipReport::create($data);
        });

        return redirect()->route('ship-reports.index')->with('message', ['type' => 'success', 'text' => 'Berhasil menambahkan data baru.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ShipReport $shipReport)
    {
        if (isset($_GET['view_photo_embarkation'])) return response()->file(storage_path($this->folder . $shipReport->photo_embarkation));
        if (isset($_GET['view_photo_departure'])) return response()->file(storage_path($this->folder . $shipReport->photo_departure));
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
        $rules = [
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
        ];
        if ($request->hasFile('photo_embarkation')) $rules['photo_embarkation'] = 'required|file|mimes:png,jpeg,jpg,bmp';
        if ($request->hasFile('photo_departure')) $rules['photo_departure'] = 'required|file|mimes:png,jpeg,jpg,bmp';
        $request->validate($rules);
        if ($request->hasFile('photo_embarkation')) $this->checkAndDeleteFile($shipReport, 'photo_embarkation');
        if ($request->hasFile('photo_departure')) $this->checkAndDeleteFile($shipReport, 'photo_departure');

        // 
        DB::transaction(function () use ($request, $shipReport, &$data) {
            $data = $request->all();
            $data['date'] = Carbon::parse($request->date);
            $data['time'] = Carbon::parse($request->time)->format('H:i');
            if ($request->hasFile('photo_embarkation'))
            {
                $file_photo_embarkation = $request->photo_embarkation;
                $file_photo_embarkation_name = Str::random(200) . '.' . $file_photo_embarkation->getClientOriginalExtension();
                $file_photo_embarkation->storeAs('data_laporan', $file_photo_embarkation_name);
                $data['photo_embarkation'] = $file_photo_embarkation_name;
            }
            if ($request->hasFile('photo_departure'))
            {
                $file_photo_departure = $request->photo_departure;
                $file_photo_departure_name = Str::random(200) . '.' . $file_photo_departure->getClientOriginalExtension();
                $file_photo_departure->storeAs('data_laporan', $file_photo_departure_name);
                $data['photo_departure'] = $file_photo_embarkation_name;
            }

            // 
            $created = $shipReport->update($data);
        });

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
        DB::transaction(function () use ($shipReport) {
            $this->checkAndDeleteFile($shipReport, 'photo_embarkation');
            $this->checkAndDeleteFile($shipReport, 'photo_departure');
            $deleted = $shipReport->delete();
        });
        return redirect()->route('ship-reports.index')->with('message', ['type' => 'success', 'text' => 'Berhasil menghapus data.']);
    }

    private function checkAndDeleteFile(ShipReport $shipReport, $column)
    {
        if ($shipReport[$column] != null) {
            try {
                Storage::delete($this->folder . $shipReport[$column]);
                unlink(storage_path($this->folder . $shipReport[$column]));
            } catch (\Throwable $th) {
            }
        }
    }
}
