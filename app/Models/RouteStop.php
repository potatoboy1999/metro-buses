<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RouteStop extends Pivot
{
    //
    protected $table = 'route_stops';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $hidden = [];

    public function route()
    {
        return $this->belongsTo(Route::class, "route_id", "id");
    }

    public function station()
    {
        return $this->belongsTo(Station::class, "station_id", "id");
    }
}
