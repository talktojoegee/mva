<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleRegDocumentType extends Model
{
    use HasFactory;

    protected $primaryKey = 'vrdt_id';
    protected $fillable = ["vrdt_name"];

    public function getDocumentTypes(){
        return VehicleRegDocumentType::orderBy("vrdt_name", "ASC")->get();
    }
}
