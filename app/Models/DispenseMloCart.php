<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DispenseMloCart extends Model
{
    use HasFactory;

    public function getPlateType(){
        return $this->belongsTo(PlateType::class, 'plate_type');
    }


    public function getLGA(){
        return $this->belongsTo(Lga::class, 'lga_code');
    }



    public function addToCart($masterId, $refCode, $dateAdded, $lgaCode, $plateType, $plateNo, $mlo, $station, $detailId){
        $cart = new DispenseMloCart();
        $cart->dispense_master = $masterId;
        $cart->added_by = Auth::user()->id;
        $cart->ref_code = $refCode;
        $cart->date_added = $dateAdded;
        $cart->lga_code = $lgaCode;
        $cart->plate_type = $plateType;
        $cart->plate_no = $plateNo;
        $cart->mlo = $mlo;
        $cart->station = $station;
        $cart->stock_receipt_detail_id = $detailId;
        $cart->save();
    }

    public function removeItemFromCart($itemId){
        $item =  DispenseMloCart::find($itemId);
        $item->delete();
    }

    public function getItemByStockReceiptDetailId($id){
        return DispenseMloCart::where("stock_receipt_detail_id", $id)->first();
    }

    public function getListOfPlatesAssignedToMlo($plateId){
        return  DispenseMloCart::where("plate_type", $plateId)->get();

    }
}
