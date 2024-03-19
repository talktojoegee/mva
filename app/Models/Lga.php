<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Lga extends Model
{
    use HasFactory;
    protected $primaryKey = 'lga_id';



    public function getAllLGAs(){
        return Lga::orderBy('lga_name', 'ASC')->get();
    }

    public function addLGA(Request $request, $userId){
        $lga = new Lga();
        $lga->lga_name = $request->lgaName ?? '' ;
        $lga->lga_code = $request->lgaCode ?? '' ;
        $lga->lga_added_by = $userId;
        $lga->save();
        return $lga;
    }
    public function editLGA(Request $request){
        $lga =  Lga::find($request->lgaId);
        $lga->lga_name = $request->lgaName ?? '' ;
        $lga->lga_code = $request->lgaCode ?? '' ;
        $lga->save();
        return $lga;
    }
}
