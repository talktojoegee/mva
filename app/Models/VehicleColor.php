<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleColor extends Model
{
    use HasFactory;

    public function getAllColors(){
        return VehicleColor::orderBy("name", "ASC")->get();
    }
}
