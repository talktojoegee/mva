<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockRequest extends Model
{
    use HasFactory;
    protected $primaryKey = 'sr_id';

    public function getStockRequestLGA(){
        return $this->belongsTo(Lga::class, 'sr_lga');
    }
    public function getRequestBy(){
        return $this->belongsTo(User::class, 'sr_requested_by');
    }

    public function getActionedBy(){
        return $this->belongsTo(User::class, 'sr_actioned_by');
    }

    public function getStockRequestDetails(){
        return $this->hasMany(StockRequestDetail::class, 'srd_stock_id');
    }


    public function submitStockRequest($lga, $requestDate){
        $stock = new StockRequest();
        $stock->sr_requested_by = Auth::user()->id;
        $stock->sr_batch_code = substr(sha1(time()),30,40);
        $stock->sr_request_date = $requestDate ?? now();
        $stock->sr_lga = $lga?? 1 ;
        $stock->save();
        return $stock;
    }

    public function updateStockRequestStatus($stockId, $status){
        $stock =  StockRequest::find($stockId);
        $stock->sr_actioned_by = Auth::user()->id;
        $stock->sr_status = $status;
        $stock->save();
        return $stock;
    }

    public function getAllStockRequests(){
        return StockRequest::orderBy('sr_id', 'DESC')->get();
    }

    public function getStockRequestByBatchCode($batchCode){
        return StockRequest::where('sr_batch_code', $batchCode)->first();
    }


    public function getStockRequestByStatus($status){
        return StockRequest::where('sr_status', $status)->orderBy('sr_id', 'DESC')->get();
    }




}
