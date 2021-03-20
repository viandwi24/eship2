<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'max_pax',
        'max_vehicle_wheel_2',
        'max_vehicle_wheel_4'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // 'schedule' => 'array',
    ];

    public function schedules()
    {
        return $this->hasMany(ShipSchedules::class);
    }
}
