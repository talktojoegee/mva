<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PlateType extends Model
{
    use HasFactory;
    protected $primaryKey = 'pt_id';

    public function getAllPlateTypes(){
        return PlateType::orderBy('pt_id', 'ASC')->get();
    }

    public function addPlateType(Request $request){
        $plate = new PlateType();
        $plate->pt_name = $request->plateType ?? '' ;
        $plate->pt_cost = $request->cost ?? '' ;
        $plate->save();
        return $plate;
    }
    public function editPlateType(Request $request){
        $plate =  PlateType::find($request->plateId);
        $plate->pt_name = $request->plateType ?? '' ;
        $plate->pt_cost = $request->cost ?? '' ;
        $plate->save();
        return $plate;
    }

    public function getStockDetailsByPlateTypeId($plateId){
        return StockRequestDetail::where("srd_plate_type", $plateId)
            ->where("srd_status",1)
            ->groupBy("srd_lga_id")
            ->sum("srd_quantity");
            //->orderBy("srd_id", "DESC")
            //->get();
    }

    public function getPlateById($plateId){
        return PlateType::find($plateId);
    }
   /* public function getLGADetailsByPlateNumber($plateId){
        $plate = $this->getPlateById($plateId);
        return Lga::where("lga_id", $plate->)->first();
    }*/
}
