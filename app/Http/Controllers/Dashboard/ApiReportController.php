<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\ShipReportsExport;
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
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class ApiReportController extends Controller
{
    public function getWeather() {
       $dataWeather = DB::select('select ship_operations.date as date, weather.id as wid, ship_operations.id as shipid from weather inner join ship_operations on weather.ship_operation_id = ship_operations.id');
       //'weather')
       //     ->join('ship_operations', 'weather.ship_operation_id', '=', 'ship_operations.id')
      //      ->get();
        return $dataWeather;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     
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

    private function test()
    {
        $date_start = Carbon::now()->firstOfMonth();
        $date_end = Carbon::now()->lastOfMonth();
        $date_start_string = Carbon::parse($date_start->format('d-m-Y'))->toDateString();
        $date_end_string = Carbon::parse($date_end->format('d-m-Y'))->toDateString();

        // 
        $eloquent = ShipOperation::with('ship')
                    ->whereDate(DB::raw('DATE(date)'), '>=', $date_start_string)
                    ->whereDate(DB::raw('DATE(date)'), '<=', $date_end_string);
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
            ->make(true);
    }*/

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function export( Request $request )
    {
        $startd = $request->start;
        $stopd = $request->stop;
        $flag = $request->flag;

        if( $flag == "true" ) {
          $date_start = Carbon::parse($startd)->firstOfMonth();
        // $date_start = Carbon::now()->firstOfMonth();
          $date_end = Carbon::parse($stopd)->lastOfMonth();
        } else {
            $date_start = Carbon::parse($startd);
        // $date_start = Carbon::now()->firstOfMonth();
        $date_end = Carbon::parse($stopd);
        }
        // $date_start = Carbon::now()->firstOfMonth();
        //$date_end = Carbon::now()->lastOfMonth();
        $date_start_string = Carbon::parse($date_start->format('d-m-Y'))->toDateString();
        $date_end_string = Carbon::parse($date_end->format('d-m-Y'))->toDateString();

        // 
        $reports = [];

        // 
        $routes = Route::select('id', 'departure', 'arrival')->get();
        $ships = Ship::select('id', 'name')->get();

        // 
        $diffDays = $date_start->diffInDays($date_end)+1;
        $currentDate = $date_start;
        for ($i=0; $i < $diffDays; $i++) { 
            $routes_arr = [];
            $routes->each(function ($route) use ($currentDate, $ships, &$routes_arr) {
                // ship
                $ships_arr = [];
                $ships->each(function ($ship) use ($currentDate, $route, &$ships_arr) {
                    $shipReport = ShipReport::whereDate('date', Carbon::parse($currentDate->format('d-m-Y'))->toDateString())
                        ->where('route_id', $route->id)
                        ->where('ship_id', $ship->id)
                        ->first();
                    $shipOperation = ShipOperation::whereDate('date', Carbon::parse($currentDate->format('d-m-Y'))->toDateString())
                        ->first();
                    //$weather = Weather::where('ship_operation_id', $shipOperation->id)
                        //->whereDate(DB::raw('DATE(date_end)'), '>=', Carbon::parse($date_end->format('d-m-Y'))->toDateString())
                    //    ->first();
                    

                    // 
                    $arr = $ship->toArray();
                    $arr['report'] = ($shipReport) ? $shipReport : null;
                    $arr['operation'] = ($shipOperation) ? $shipOperation : null;
                    //$arr['weather'] = ($weather) ? $weather : null;
                    $ships_arr[] = $arr;
                });

                // 
                $arr = $route->toArray();
                $arr['ships'] = $ships_arr;
                $routes_arr[] = $arr;
            });
            $reports[] = [
                'date' => $currentDate->format('d-m-Y'),
                'routes' => $routes_arr
            ];
            $currentDate->addDays(1);
        }

        // 


        // 
        // return ($reports);
        $xls = true;
        //return Excel::download(new ShipReportsExport(compact('routes', 'ships', 'reports', 'xls')), 'report('.$date_start_string.'-'.$date_end_string.').xlsx');
        // return view('excels.ship-report', compact('routes', 'ships', 'reports', 'xls'));
        
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

        return $reports;
    }

    private function recursive_array_search($needle, $haystack) {
        foreach($haystack as $key=>$value) {
            $current_key=$key;
            if($needle===$value OR (is_array($value) && $this->recursive_array_search($needle,$value) !== false)) {
                return $current_key;
            }
        }
        return false;
    }
}
