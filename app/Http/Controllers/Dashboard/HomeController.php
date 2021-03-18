<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Ship;
use App\Models\ShipReport;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $routes = Route::all();
        $ships = Ship::all();

        // 
        $reports = $this->makeReport();

        // 
        return view('pages.dashboard.index', compact('routes', 'ships', 'reports'));
    }

    private function makeReport()
    {
        $date_start = Carbon::now()->firstOfMonth();
        $date_end = Carbon::now()->lastOfMonth();

        // 
        $routes = Route::select('id', 'departure', 'arrival')->get();
        $ships = Ship::all();

        // 
        $result = [
            'route' => $routes->toArray()
        ];

        // 
        $result['load_factor_label'] = [];
        $diffDays = $date_start->diffInDays($date_end)+1;
        $currentDate = clone $date_start;
        for ($j=0; $j < $diffDays; $j++)
        { 
            $result['load_factor_label'][] = $currentDate->format('d');
            $currentDate->addDays(1);
        }
        $result['load_factor_label'] = "'" . implode("', '", $result['load_factor_label']) . "'";
        // dd($result['load_factor_label']);


        // 
        $i = 0;
        $tmpResultRouteReports = [];
        $tmpResultRouteReports[] = ['key' => 0];
        foreach ($routes as $route) {
            // init
            $result['route'][$i]['count_adult'] = 0;
            $result['route'][$i]['count_baby'] = 0;
            $result['route'][$i]['count_security_forces'] = 0;
            $result['route'][$i]['count_vehicle_wheel_2'] = 0;
            $result['route'][$i]['count_vehicle_wheel_4'] = 0;
            $result['route'][$i]['load_factor_pax'] = [];


            // get pax & vehicle
            $shipReports = ShipReport::whereRouteId($route->id)->whereBetween('date', [$date_start, $date_end])->get();
            $shipReports->each(function (ShipReport $shipReport) use ($i, &$result, &$tmpResultRouteReports) 
            {
                $result['route'][$i]['count_adult'] += $shipReport->count_adult;
                $result['route'][$i]['count_baby'] += $shipReport->count_baby;
                $result['route'][$i]['count_security_forces'] += $shipReport->count_security_forces;
                $result['route'][$i]['count_vehicle_wheel_2'] += $shipReport->count_vehicle_wheel_2;
                $result['route'][$i]['count_vehicle_wheel_4'] += $shipReport->count_vehicle_wheel_4;
                $tmp = [];
                $tmp['count_adult'] = $shipReport->count_adult;
                $tmp['count_baby'] = $shipReport->count_baby;
                $tmp['count_security_forces'] = $shipReport->count_security_forces;
                $tmp['count_vehicle_wheel_2'] = $shipReport->count_vehicle_wheel_2;
                $tmp['count_vehicle_wheel_4'] = $shipReport->count_vehicle_wheel_4;
                $tmp['key'] = $shipReport->route_id.'-'.$shipReport->ship_id.'-'.Carbon::parse($shipReport->date)->format('d');
                $tmpResultRouteReports[] = $tmp;
            });
            $result['route'][$i]['count_pax'] = $result['route'][$i]['count_adult'] + $result['route'][$i]['count_baby'] + $result['route'][$i]['count_security_forces'];
            // dd($tmpResultRouteReports);

            // get load factor pax
            $diffDays = $date_start->diffInDays($date_end)+1;
            $currentDate = clone $date_start;
            foreach ($ships as $ship)
            {
                $tmpRoute = [
                    'id' => $ship->id,
                    'name' => $ship->name
                ];
                for ($j=0; $j < $diffDays; $j++) 
                { 
                    // 
                    $percent = 0;

                    // 
                    $search_key = $route->id.'-'.$ship->id.'-'.$currentDate->format('d');
                    $search = null;
                    foreach ($tmpResultRouteReports as $key => $value) { if ($value['key'] == $search_key) $search = $key; }
                    // if ($search_key == '1-1-17') dd($tmpResultRouteReports);

                    // 
                    if ($search != null)
                    {
                        $pax = $tmpResultRouteReports[$search];
                        $percent = ((
                            $pax['count_adult'] + $pax['count_baby'] + $pax['count_security_forces']
                            + $pax['count_vehicle_wheel_2'] + $pax['count_vehicle_wheel_4']
                        ) / ($ship->max_pax + $ship->max_vehicle_wheel_2 + $ship->max_vehicle_wheel_4)) * 100;
                    }

                    //
                    $tmpRoute['percents'][] = [
                        'date' => $currentDate->format('d'),
                        'percent' => number_format((float) $percent, 2, '.', '')
                    ];
                    $currentDate->addDays(1);
                }
                $result['route'][$i]['load_factor_pax']['ship'][] = $tmpRoute;
            }

            // 
            $i++;
        }
        return $result;
    }
}
