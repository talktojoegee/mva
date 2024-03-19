<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Station extends Model
{
    use HasFactory;


    public function addStation(Request $request){
        $station = new Station();
        $station->name = $request->stationName ?? '';
        $station->save();
    }

    public function editStation(Request $request){
        $station =  Station::find($request->stationId);
        $station->name = $request->stationName ?? '';
        $station->save();
    }

    public function getAllStations(){
        return Station::orderBy('name', 'ASC')->get();
    }
}
