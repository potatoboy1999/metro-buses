<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;
    protected $table = 'routes';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $hidden = [];

    public function bus()
    {
        return $this->belongsTo(Bus::class, "bus_id", "id");
    }

    public function stops()
    {
        return $this->hasMany(RouteStop::class, "route_id", "id");
    }

    public function stations()
    {
        return $this->belongsToMany(Station::class, 'route_stops', 'route_id', 'station_id')
                    ->where('stations.status', 1)
                    ->withPivot('order')
                    ->orderByPivot('order', 'asc');
    }

    /*
    public function stations()
    {
        return $this->hasManyThrough(
            Station::class,
            RouteStop::class,
            'route_id', // Foreign key on RouteStop table
            'id', // Foreign key on Station table
            'id', // Local key on Route table
            'station_id' // Local key on RouteStop table
        );
    }*/

}
