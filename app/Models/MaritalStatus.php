<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaritalStatus extends Model
{
    use HasFactory;

    protected $primaryKey = 'ms_id';
    protected $fillable = ['ms_name'];


    public function getMaritalStatuses(){
        return MaritalStatus::all();
    }



}
