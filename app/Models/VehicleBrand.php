<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleBrand extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function getVehicleBrands(){
        return VehicleBrand::orderBy('name', 'ASC')->get();
    }
}
