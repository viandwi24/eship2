<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Ship;
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
    public function export()
    {
        $date_start = Carbon::now()->firstOfMonth();
        $date_end = Carbon::now()->lastOfMonth();
        $date_start_string = Carbon::parse($date_start->format('d-m-Y'))->toDateString();
        $date_en_string = Carbon::parse($date_end->format('d-m-Y'))->toDateString();

        // 
        $reports = [];

        // 
        $routes = Route::select('id', 'departure', 'arrival')->get();
        $ships = Ship::select('id', 'name')->get();

        // 
        $ships_arr = [];
        $ships->each(function ($val, $key) use (&$ships_arr) {
            $arr = $val->toArray();
            $ships_arr[] = $arr;
        });

        // 
        $diffDays = $date_start->diffInDays($date_end)+1;
        $current = $date_start;
        for ($i=0; $i < $diffDays; $i++) { 
            $routes_arr = [];
            $routes->each(function ($val, $key) use (&$routes_arr, $ships_arr) {
                $arr = $val->toArray();
                $arr['ships'] = $ships_arr;
                $routes_arr[] = $arr;
            });
            $reports[] = [
                'date' => $date_start->format('d-m-Y'),
                'routes' => $routes_arr
            ];
            $current->addDays(1);
        }
        return ($reports);
        
        // // 
        // $shipOperations = ShipOperation::with('ship')
        //         ->whereBetween('date', [$date_start, $date_end])
        //         ->get()
        //         ->toArray();
        // foreach ($shipOperations as $key => $val) { $shipOperations[$key]['date'] = Carbon::parse($val['date'])->format('d-m-Y'); }
        
        // // 
        // $shipReports = ShipReport::with('ship')
        //         ->whereBetween('date', [$date_start, $date_end])
        //         ->get()
        //         ->toArray();
        // foreach ($shipReports as $key => $val) { $shipReports[$key]['date'] = Carbon::parse($val['date'])->format('d-m-Y'); }

        // // 
        // foreach ($shipReports as $shipReport)
        // {
        //     $found = array_search($shipReport['date'], array_column($shipOperations, 'date'));
        //     if ($found != false) $shipOperations[$found]['reports'][] = $shipReport;
        // }

        // return $shipOperations;
    }
}
