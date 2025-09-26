<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Station extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'stations';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'name',
        'full_address',
        'distring',
        'lat',
        'lng',
    ];

    public function stops()
    {
        return $this->hasMany(RouteStop::class, "station_id", "id");
    }

    public function routes()
    {
        return $this->belongsToMany(Route::class, 'route_stops', 'station_id', 'route_id')
                    ->withPivot('order')
                    ->orderByPivot('order', 'asc');
    }
}
