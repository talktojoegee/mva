<?php

namespace App\Imports;

use App\Models\Lga;
use App\Models\StockReceiptDetail;
use Maatwebsite\Excel\Concerns\ToModel;

class StockReceiptImport implements ToModel
{
    public $receiptId;
    public function __construct($id){
        $this->receiptId = $id;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $lga = Lga::where("lga_code", $row[1])->first();
        return new StockReceiptDetail([
            "stock_receipt_master"=>$this->receiptId,
            "lga_code"=> $lga->lga_id ?? 1, //$row[1],
            "plate_id"=>$row[2],
            "plate_no"=>$row[3],
        ]);

    }
}
