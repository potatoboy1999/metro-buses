<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;
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

    protected $hidden = [];

    public function stops()
    {
        return $this->hasMany(RouteStop::class, "station_id", "id");
    }
}
