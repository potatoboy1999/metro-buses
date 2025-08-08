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

}
