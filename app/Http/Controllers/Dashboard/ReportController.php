<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ShipOperation;
use App\Models\ShipReport;
use App\Models\Weather;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ajax = $request->ajax();
        // $ajax = true;
        if ($ajax)
        {
            $eloquent = ShipOperation::with('ship');
            return DataTables::of($eloquent)
                ->editColumn('date', function ($q) { return date('d-m-Y', strtotime($q->date)); })  
                ->addColumn('petugas', function (ShipOperation $shipOperation) {
                    $petugas = ShipReport::with('user')->where('date', $shipOperation->date)->get();
                    return $petugas->pluck('user.name')->unique()->join(', ');
                })
                ->addColumn('pax', function (ShipOperation $shipOperation) {
                    $reports = ShipReport::where('date', $shipOperation->date)->get();
                    $pax = 0;
                    foreach ($reports as $item)
                    {
                        $pax += $item->count_adult
                            + $item->count_baby
                            + $item->count_security_forces;
                    }
                    return $pax;
                })
                ->addColumn('weather', function (ShipOperation $shipOperation) {
                    $date = $shipOperation->date;
                    $weather = Weather::whereDate(DB::raw('DATE(date_start)'), '<=', Carbon::parse($date)->toDateString())
                        ->whereDate(DB::raw('DATE(date_end)'), '>=', $date)
                        ->first();
                    return $weather;
                })
                ->filter(function (Builder $q) use ($request) {
                    if ($request->has('date_start')) {
                        $q->whereDate(DB::raw('DATE(date)'), '>=', Carbon::parse($request->date_start)->toDateString());
                    }
                    if ($request->has('date_end')) {
                        $q->whereDate(DB::raw('DATE(date)'), '<=', Carbon::parse($request->date_end)->toDateString());
                    }
                })
                ->make(true);
        }
        return view('pages.dashboard.report.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
