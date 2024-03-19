<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockReceipt extends Model
{
    use HasFactory;

    public function getReceivedBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getActionedBy(){
        return $this->belongsTo(User::class, 'actioned_by');
    }

    public function getStockReceiptDetails(){
        return $this->hasMany(StockReceiptDetail::class, 'stock_receipt_master');
    }

    public function addStockReceipt(Request $request){
        $receipt = new StockReceipt();
        $receipt->created_by = Auth::user()->id;
        $receipt->ref_code = substr(sha1(time()),30,40);
        $receipt->receipt_date = $request->receiptDate ?? now();
        $receipt->attachment = $this->uploadFile($request);
        $receipt->save();
        return $receipt;
    }

    public function getAllStockReceipts(){
        return StockReceipt::orderBy('id', 'DESC')->get();
    }

    public function uploadFile(Request $request)
    {
        if ($request->hasFile('attachment')) {
            //return dd('yes');
            $file = $request->attachment;
            $extension = $file->getClientOriginalExtension();
            $filename = uniqid() . '_' . time() . '_' . date('Ymd') . '.' . $extension;
            $dir = 'assets/drive/import/';
            $file->move(public_path($dir), $filename);
            return $filename;

        }

    }



    public function getStockReceiptByRefCode($refCode){
        return StockReceipt::where('ref_code', $refCode)->first();
    }

    public function getStockReceiptById($id){
        return StockReceipt::find($id);
    }


    public function getStockReceiptByStatus($status){
        return StockReceipt::where('status', $status)->orderBy('sr_id', 'DESC')->get();
    }


    public function updateStockRequestStatus($stockId, $status){
        $stock =  StockReceipt::find($stockId);
        $stock->actioned_by = Auth::user()->id;
        $stock->date_actioned = now();
        $stock->status = $status;
        $stock->save();
        return $stock;
    }
}
