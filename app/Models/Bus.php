<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Bus extends Model
{
    use HasFactory;
    protected $table = 'buses';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'code_name',
        'full_name',
        'express',
    ];

    protected $hidden = [];

    public function routes() : HasMany
    {
        return $this->hasMany(Route::class, "bus_id", "id");
    }

    public function stops(): HasManyThrough
    {
        return $this->hasManyThrough(RouteStop::class,Route::class,"bus_id", "route_id", "id", "id");
    }

}
