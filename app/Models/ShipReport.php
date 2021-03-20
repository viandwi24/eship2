<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipReport extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'ship_id',
        'route_id',
        'date',
        'time',
        'count_adult',
        'count_baby',
        'count_security_forces',
        'count_vehicle_wheel_2',
        'count_vehicle_wheel_4',
        'photo_embarkation',
        'photo_departure',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
    ];

    public function ship()
    {
        return $this->belongsTo(Ship::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }
}
