<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;



    public function getCurrencies(){
        return Currency::orderBy('name', 'ASC')->get();
    }


}
