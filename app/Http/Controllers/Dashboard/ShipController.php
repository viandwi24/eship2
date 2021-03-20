<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Ship;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

use function PHPUnit\Framework\isNull;

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
        // 
        // dd($request->all());

        // 
        $data = $request->all();

        // 
        $request->validate([
            'name' => 'required|string|min:3|max:250',
            'type' => 'required|string|in:Kapal Motor,Kapal Cepat',
        ]);
        $defaultForNumberInput = ['max_pax', 'max_vehicle_wheel_2', 'max_vehicle_wheel_4'];
        foreach ($defaultForNumberInput as $input)
        {
            if ($request->has($input))
            {
                $request->validate([$input => 'nullable|integer|min:0']);
                $data[$input] = ($request->{$input} == null) ? 0 : $request->{$input};
            } else {
                $data[$input] = 0;
            }
        }

        // 
        if ($request->has('days')) 
        {
            $request->validate([
                'days.*' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
                'time.*' => 'required|date_format:G:i'
            ]);
        }

        // 
        DB::transaction(function () use ($data, $request, &$created) {
            $ship = Ship::create($data);
            foreach ($request->days as $key => $day) 
            {
                $ship->schedules()->create([
                    'day' => $request->days[$key],
                    'time' => Carbon::parse($request->time[$key]),
                ]);
            }
        });

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
        if ($ship->type != $request->type) {
            $rules['type'] = 'required|string|in:Kapal Motor,Kapal Cepat';
            $data['type'] = $request->type;
        }
        $request->validate($rules);

        // 
        $defaultForNumberInput = ['max_pax', 'max_vehicle_wheel_2', 'max_vehicle_wheel_4'];
        foreach ($defaultForNumberInput as $input)
        {
            if ($request->has($input))
            {
                $request->validate([$input => 'nullable|integer|min:0']);
                $data[$input] = ($request->{$input} == null) ? 0 : $request->{$input};
            } else {
                $data[$input] = 0;
            }
        }

        // 
        if ($request->has('days')) 
        {
            $request->validate([
                'days.*' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
                'time.*' => 'required|date_format:G:i'
            ]);
        }

        // 
        DB::transaction(function () use ($data, $ship, $request, &$updated) {
            $updated = $ship->update($data);
            $ship->schedules()->delete();
            foreach ($request->days as $key => $day) 
            {
                $ship->schedules()->create([
                    'day' => $request->days[$key],
                    'time' => Carbon::parse($request->time[$key]),
                ]);
            }
        });

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
