<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StockRequestDetail extends Model
{
    use HasFactory;
    protected $primaryKey = "srd_id";

    public function getPlateType(){
        return $this->belongsTo(PlateType::class, 'srd_plate_type');
    }

    public function getLGA(){
        return $this->belongsTo(Lga::class, "srd_lga_id");
    }

    public function addStockRequestDetails($lgaCode, $plateType, $quantity, $requestDate){
        $details = new StockRequestDetail();
        $details->srd_lga_id = $lgaCode;
        $details->srd_plate_type = $plateType;
        $details->srd_quantity = $quantity;
        $details->srd_request_date = $requestDate;
        $details->save();
    }

    public function getDetailByLgaCodeStatus($lgaId, $status){
        return StockRequestDetail::where('srd_lga_id', $lgaId)->where("srd_status", $status)->get();
    }


    public function getAllPendingRequests($status){
        return StockRequestDetail::where("srd_status", $status)->orderBy("srd_id", "DESC")->get();
    }


    public function getDetailsByStockId($stockId){
        return StockRequestDetail::where("srd_stock_id", $stockId)->get();
    }


    public function getDistinctDetailsByStockId($stockId){
        return StockRequestDetail::where("srd_stock_id", $stockId)->groupBy("srd_lga_id")->get();
    }
    public function getDistinctDetailsByLGA($stockId){
        return StockRequestDetail::where("srd_stock_id", $stockId)->groupBy("srd_lga_id")->get();
    }

    public static function  getSumByPlateType($stockId, $lga){
        return StockRequestDetail::/*where("srd_plate_type", $plateType)*/
            where("srd_stock_id", $stockId)
            ->where("srd_lga_id", $lga)
            ->distinct("srd_plate_type")
            //->groupBy("srd_lga_id")
            //->sum("srd_quantity");
            ->get();
    }

    public function getStockReceiptRecords($stockId){
        return DB::table("stock_request_details")
            ->select("stock_request_details.*",
            "plate_types.pt_name", "plate_types.pt_cost", "lgas.lga_name", "lgas.lga_code")
            ->join("plate_types", "plate_types.pt_id", "=", "stock_request_details.srd_plate_type")
            ->join("lgas", "lgas.lga_id", "=", "stock_request_details.srd_lga_id")
            ->distinct("stock_request_details.srd_lga_id")
            ->where("stock_request_details.srd_status", "=",1)
            ->where("stock_request_details.srd_stock_id", "=",$stockId)
            ->groupBy("stock_request_details.srd_lga_id")
            //->sum("stock_request_details.srd_quantity")
            ->get();
    }



    public function getRequestDetailById($id){
        return StockRequestDetail::find($id);
    }





}
