<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Weather;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class WeatherController extends Controller
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
            $eloquent = Weather::query();
            return DataTables::of($eloquent)
                ->editColumn('date_start', function ($q) { return date('d-m-Y', strtotime($q->date_start)); })
                ->editColumn('date_end', function ($q) { return date('d-m-Y', strtotime($q->date_end)); })
                ->make(true);
        }
        return view('pages.dashboard.weather.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dashboard.weather.create');
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
            'date_start' => 'required|date',
            'date_end' => 'required|date',
            'file' => 'required|file|mimes:pdf'
        ]);

        $date_start = Carbon::parse($request->date_start);
        $date_end = Carbon::parse($request->date_end);
        $date_diff = $date_start->diffInDays($date_end, false);

        if ($date_diff <= 0) return redirect()->back()->withInput()->with('message', ['type' => 'danger', 'text' => 'Tanggal Selesai Harus Lebih Besar daripada tangggal Mulai.']);

        $file = $request->file;
        $file_name = Str::random(200) . '.' . $file->getClientOriginalExtension();
        $file->storeAs('data_cuaca', $file_name);

        $created = Weather::create([
            'date_start' => $date_start,
            'date_end' => $date_end,
            'file' => $file_name
        ]);

        return redirect()->route('weather.index')->with('message', ['type' => 'success', 'text' => 'Berhasil menambahkan data cuaca.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Weather $weather)
    {
        if (isset($_GET['view']))
        {
            $path = storage_path('app/data_cuaca/' . $weather->file);
            return response()->file($path);
        }
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Weather $weather)
    {
        $deleted = $weather->delete();
        return redirect()->route('weather.index')->with('message', ['type' => 'success', 'text' => 'Berhasil menghapus data cuaca.']);
    }
}
