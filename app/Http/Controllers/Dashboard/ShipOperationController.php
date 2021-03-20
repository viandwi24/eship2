<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Ship;
use App\Models\ShipOperation;
use App\Models\Weather;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class ShipOperationController extends Controller
{
    public $folder = 'data_cuaca';

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
        if ($request->status == 'Tidak Beroperasi' && $request->description == 'Cuaca Buruk') $request->validate(['file' => 'required|file|mimes:pdf']);

        // 
        DB::transaction(function () use ($data, $request, &$created) {
            if ($request->status == 'Tidak Beroperasi' && $request->description == 'Cuaca Buruk')
            {
                $file = $request->file;
                $file_name = Str::random(200) . '.' . $file->getClientOriginalExtension();
                $file->storeAs($this->folder, $file_name);
            }
            
            $created = ShipOperation::create($data);

            if ($request->status == 'Tidak Beroperasi' && $request->description == 'Cuaca Buruk')
            {
                $created->weather()->create([
                    'file' => $file_name
                ]);
            }
        });

        return redirect()->route('ship-operations.index')->with('message', ['type' => 'success', 'text' => 'Berhasil menambahkan data baru.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ShipOperation $shipOperation)
    {
        if (isset($_GET['view']))
        {
            $path = storage_path('app/'.$this->folder.'/' . $shipOperation->weather->file);
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
        if ($request->status == 'Tidak Beroperasi' && $request->description == 'Cuaca Buruk' && $request->hasFile('file'))
        {
            $request->validate(['file' => 'required|file|mimes:pdf']);
            if ($shipOperation->weather->file != null) {
                try {
                    Storage::delete($this->folder . $shipOperation->weather->file);
                    unlink(storage_path($this->folder . $shipOperation->weather->file));
                } catch (\Throwable $th) {
                }
            }
        }
        $request->validate($rules);

        // 
        DB::transaction(function () use ($data, $request, $shipOperation, &$updated) {
            $updated = $shipOperation->update($data);

            if ($request->status == 'Tidak Beroperasi' && $request->description == 'Cuaca Buruk' && $request->hasFile('file'))
            {
                $file = $request->file;
                $file_name = Str::random(200) . '.' . $file->getClientOriginalExtension();
                $file->storeAs($this->folder, $file_name);
                $shipOperation->weather()->update(['file' => $file]);
            }
        });

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

    private function checkAndDeleteFile(ShipOperation $shipOperation, $column)
    {
        if ($shipOperation[$column] != null) {
            try {
                Storage::delete($this->folder . $shipOperation[$column]);
                unlink(storage_path($this->folder . $shipOperation[$column]));
            } catch (\Throwable $th) {
            }
        }
    }
}
