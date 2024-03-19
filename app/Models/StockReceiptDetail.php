<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockReceiptDetail extends Model
{
    use HasFactory;
protected $fillable = [
    'stock_receipt_master',
    'lga_code',
    'plate_id',
    'plate_no',
    ];

    public function getPlateType(){
        return $this->belongsTo(PlateType::class, 'plate_id');
    }
    public function getLga(){
        return $this->belongsTo(Lga::class, 'lga_code');
    }


    public function getAllStockReceiptsByStatus($status){
        return StockReceiptDetail::where("dispense_status", $status)->orderBy("id", "DESC")->get();
    }


    public function getOneParentStockReceiptDetail($parentId){
        return StockReceiptDetail::where("id", $parentId)->first();
    }

    public function getOneDetailById($id){
        return StockReceiptDetail::find($id);
    }

    public function getStockReceiptDetailByPlateNo($plateNo){
        return StockReceiptDetail::where("plate_no", $plateNo)->first();
    }

    public function getOneStockReceiptById($id){
        return StockReceipt::find($id);
    }


    public function getStockReceiptRecordsForMloDispense($stockId){
        return DB::table("stock_receipt_details")
            ->select("stock_receipt_details.*",
                "plate_types.pt_name", "plate_types.pt_cost", "lgas.lga_name", "lgas.lga_code")
            ->join("plate_types", "plate_types.pt_id", "=", "stock_receipt_details.plate_id")
            ->join("lgas", "lgas.lga_id", "=", "stock_receipt_details.lga_code")
            ->distinct("stock_receipt_details.lga_code")
            ->where("stock_receipt_details.dispense_status", "=",1)
            ->where("stock_receipt_details.stock_receipt_master", "=",$stockId)
            ->groupBy("stock_receipt_details.lga_code")
            ->get();
    }

    public static function  getSumByPlateType($stockId, $lga){
        return StockReceiptDetail::where("stock_receipt_master", $stockId)
            ->where("lga_code", $lga)
            ->distinct("plate_id")
            ->get();
    }


    public function getListOfPlatesAssignedToMlo($plateId){
        return  StockReceiptDetail::where("plate_id", $plateId)
            ->where("mlo_id", Auth::user()->getMloDetails->ms_id)
            ->where("locked",0)
            ->where("sold",0)
            ->get();

    }
}
