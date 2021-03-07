<?php

namespace Database\Seeders;

use App\Models\Ship;
use App\Models\ShipOperation;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ShipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ship::create(['name' => 'KM. EXPRESS BAHARI BE']);
        Ship::create(['name' => 'KM. NATUNA EXPRESS']);
        Ship::create(['name' => 'KMP. GILIYANG']);

        ShipOperation::create([
            'ship_id' => 1,
            'date' => Carbon::parse('01-03-2021'),
            'status' => 'Beroperasi',
            'description' => 'Aman',
            'location' => 'Gresik'
        ]);
        ShipOperation::create([
            'ship_id' => 2,
            'date' => Carbon::parse('01-03-2021'),
            'status' => 'Beroperasi',
            'description' => 'Aman',
            'location' => 'Gresik'
        ]);
        ShipOperation::create([
            'ship_id' => 3,
            'date' => Carbon::parse('01-03-2021'),
            'status' => 'Beroperasi',
            'description' => 'Aman',
            'location' => 'Gresik'
        ]);
    }
}