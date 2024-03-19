<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Imports\StockReceiptImport;
use App\Models\DispenseMloCart;
use App\Models\DispenseMloMaster;
use App\Models\Lga;
use App\Models\MloSetup;
use App\Models\PlateType;
use App\Models\StockReceipt;
use App\Models\StockReceiptDetail;
use App\Models\StockRequest;
use App\Models\StockRequestDetail;
use App\Models\VehicleModel;
use Illuminate\Http\Request;
use Excel;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->platetype = new PlateType();
        $this->lga = new Lga();
        $this->stockrequest = new StockRequest();
        $this->stockrequestdetail = new StockRequestDetail();
        $this->stockreceipt = new StockReceipt();
        $this->stockreceiptdetail = new StockReceiptDetail();
        $this->mlo = new MloSetup();
        $this->dispensemlocart = new DispenseMloCart();
        $this->dispensemlomaster = new DispenseMloMaster();
        $this->vehiclemodel = new VehicleModel();
    }


    public function showApproveStockRequisitionForm(){
        return view('stock.approve-request',[
            'stocks'=>$this->stockrequest->getAllStockRequests()
        ]);
    }


    public function showPrintStockRequisitionView(){
        return view('stock.approved-request',[
            'stocks'=>$this->stockrequest->getStockRequestByStatus(1)
        ]);
    }

    public function showStockRequisitionForm(){
        return view('stock.index',[
            'plateTypes'=>$this->platetype->getAllPlateTypes(),
            'lgas'=>$this->lga->getAllLGAs(),
            'stocks'=>$this->stockrequest->getAllStockRequests(),
            "requestList"=>$this->stockrequestdetail->getAllPendingRequests(0)
        ]);
    }


    public function newStockRequest(Request $request){
        $this->validate($request,[
            "requestDate"=>"required|date",
            "lgaCode"=>"required",
            "plateType"=>"required|array",
            "quantity"=>"required|array",
        ]);
        //Check if selected LGA has pending request yet to be submitted or approved
        $lgaRequest = $this->stockrequestdetail->getDetailByLgaCodeStatus($request->lgaCode, 0);
        if(count($lgaRequest) > 0){
            session()->flash("error", "Whoops! There is a pending request for this LGA.");
            return back();
        }
       //$stock = $this->stockrequest->submitStockRequest($request);
       for($i = 0; $i<count($request->plateType); $i++){
           if($request->quantity[$i] > 0){
               $this->stockrequestdetail->addStockRequestDetails(
                   $request->lgaCode,
                   $request->plateType[$i],
                   $request->quantity[$i],
                   $request->requestDate,
               );
           }
       }
        session()->flash("success", "Success! Request submitted.");
        return back();

    }

    public function processStockRequisitionRequest(){
        $record = $this->stockrequestdetail->getAllPendingRequests( 0);
        if(count($record) <= 0){
            session()->flash("error", "Whoops! No record found.");
            return back();
        }
        $firstRecord = $record->first();
       $stock = $this->stockrequest->submitStockRequest($firstRecord->srd_lga_id, $firstRecord->srd_request_date);
       foreach($record as $rec ){
         $detail = $this->stockrequestdetail->getRequestDetailById($rec->srd_id);
         if(!empty($detail)){
             $detail->srd_status = 1; //submitted
             $detail->srd_stock_id = $stock->sr_id;
             $detail->save();
         }

       }
        session()->flash("success", "Success! Request submitted.");
        return back();
    }
    public function removeItemFromStockRequestDetail(Request $request){
        $item = $this->stockrequestdetail->getRequestDetailById($request->itemId);
        if(empty($item)){
            abort(404);
        }
        $item->delete();
        session()->flash("success", "Success! Action successful");
        return back();
    }
    public function approveStockRequest(Request $request){
        $this->validate($request,[
            "stockId"=>"required",
        ]);

       $this->stockrequest->updateStockRequestStatus($request->stockId, 1);
        session()->flash("success", "Success! Action successful");
        return back();

    }

    public function showStockRequestDetails(Request $request){
        $slug = $request->slug;
        if(empty($slug)){
            abort(404);
        }
        $stock = $this->stockrequest->getStockRequestByBatchCode($slug);
        if(empty($stock)){
            session()->flash("error", "Whoops! No record found");
            return back();
        }

        return view("stock.view",[
            "stock"=>$stock,
            "plateTypes"=>$this->platetype->getAllPlateTypes(),
            "stockDetails"=> collect( $this->stockrequestdetail->getStockReceiptRecords($stock->sr_id))//$this->stockrequestdetail->getDistinctDetailsByStockId($stock->sr_id)
        ]);

    }


    public function showStockReceipt(){
        return view("stock.stock-receipt");
    }

    public function uploadStockReceipt(Request $request){
        $this->validate($request,[
            "receiptDate"=>"required|date",
            "attachment"=>"required"
        ]);
        $receipt = $this->stockreceipt->addStockReceipt($request);
        Excel::import(new StockReceiptImport($receipt->id,  ), public_path("assets/drive/import/{$receipt->attachment}"));
        session()->flash("success", "Success! Action successful");
        return back();
    }

    public function manageStockReceipt(){
        return view("stock.manage-stock-receipt",[
            "stocks"=>$this->stockreceipt->getAllStockReceipts()
        ]);
    }

    public function showStockReceiptDetails(Request $request){
        $slug = $request->slug;
        if(empty($slug)){
            abort(404);
        }
        $stock = $this->stockreceipt->getStockReceiptByRefCode($slug);
        if(empty($stock)){
            session()->flash("error", "Whoops! No record found");
            return back();
        }
        return view("stock.stock-receipt-view",[
            "stock"=>$stock
        ]);

    }

    public function approveStockReceipt(Request $request){
        $this->validate($request,[
            "stockId"=>"required",
        ]);

        $this->stockreceipt->updateStockRequestStatus($request->stockId, 1);
        session()->flash("success", "Success! Action successful");
        return back();

    }


    public function showDispenseToMLOView(){
        return view("stock.dispense-to-mlo",[
            "mlos"=>$this->mlo->getMloSetups(),
            "pendingStocks"=>$this->stockreceiptdetail->getAllStockReceiptsByStatus(0),
            "cartStocks"=>$this->stockreceiptdetail->getAllStockReceiptsByStatus(2),
        ]);
    }

    public function processDispenseToMLOCart(Request $request){
        $this->validate($request,[
            "date"=>"required|date",
            "mlo"=>"required",
            "plateNumber"=>"required|array",
            "plateNumber.*"=>"required"
        ]);
        $refCode = substr(sha1(time()),30,40);
        $dispenseMaster = $this->dispensemlomaster->addDispenseMaster(Auth::user()->id, $refCode, $request->mlo, $request->date);

        for($i = 0; $i < count($request->plateNumber); $i++){
            $detail = $this->stockreceiptdetail->getOneParentStockReceiptDetail($request->plateNumber[$i]);
            if(!empty($detail)){
                $stockReceipt = $this->stockreceipt->getStockReceiptById($detail->stock_receipt_master);
                if(!empty($stockReceipt)){
                    $stockReceipt->ref_code = $refCode;
                    $stockReceipt->save();
                    $one = $this->stockreceiptdetail->getOneDetailById($request->plateNumber[$i]);
                    $station = $this->mlo->getMloById($request->mlo);
                    $this->dispensemlocart->addToCart($dispenseMaster->id, $refCode,
                        $request->date, $detail->lga_code ?? 'N/A', $one->plate_id, $detail->plate_no,
                        $request->mlo, $station->ms_station, $detail->id);
                    //Added to cart
                    $detail->dispense_status = 2; //added to cart
                    $detail->save();
                }else{
                    abort(404);
                }
            }else{
                abort(404);
            }


        }
        session()->flash("success", "Success! Action successful");
        return back();

    }

    public function removeItemFromCart(Request $request){
        $this->validate($request,[
            "itemId"=>"required"
        ]);
        $item = $this->stockreceiptdetail->getOneDetailById($request->itemId);
        if(empty($item)){
            abort(404);
        }
        $item->dispense_status = 0;
        $item->save();
        session()->flash("success", "Success! Action successful");
        return back();
    }
    public function dispenseItemsToMLO(){
        $items = $this->stockreceiptdetail->getAllStockReceiptsByStatus(2);
        foreach($items as $item){
            $mloCart = $this->dispensemlocart->getItemByStockReceiptDetailId($item->id);
            if(!empty($mloCart)){
                $item->dispense_status = 1; //dispensed
                $item->mlo_id = $mloCart->mlo;
                $item->station = $mloCart->station;
                //$item->locked = 1; // reserved
                $item->save();
            }

        }
        session()->flash("success", "Success! Action successful");
        return back();
    }

    public function showApproveDispenseMloView(){
        return view("stock.approve-dispense-to-mlo",[
            "items"=>$this->dispensemlomaster->getDispenseMasterByStatus(0)
        ]);
    }

    public function showDispenseRequestDetails($slug){
        if(empty($slug)){
            abort(404);
        }
        $item = $this->dispensemlomaster->getDispenseMasterByRefCode($slug);
        if(empty($item)){
            abort(404);
        }
        $stockReceipt = $this->stockreceipt->getStockReceiptByRefCode($slug);
        if(empty($stockReceipt)){
            abort(404);
        }
        return view("stock.dispense-to-mlo-view",[
            "stock"=>$stockReceipt,
            "item"=>$item,
            "plateTypes"=>$this->platetype->getAllPlateTypes(),
            "stockDetails"=> collect( $this->stockreceiptdetail->getStockReceiptRecordsForMloDispense($stockReceipt->id))
        ]);
    }

    public function getVehicleModel(Request $request){
        $models = $this->vehiclemodel->getVehicleModelsByBrandId($request->brandId);
        return view("stock.partials._vehicle-models",[
            "models"=>$models
        ]);
    }

    public function getNumberPlateType(Request $request){
        $plateId = $request->plateId;
        //$plates = $this->dispensemlocart->getListOfPlatesAssignedToMlo($plateId);
        $plates = $this->stockreceiptdetail->getListOfPlatesAssignedToMlo($plateId);
        return view("stock.partials._list-of-plates",[
            "plates"=>$plates
        ]);
    }

    public function showPrintRequestView(Request $request){
        $slug = $request->slug;
        if(empty($slug)){
            abort(404);
        }
        $stock = $this->stockrequest->getStockRequestByBatchCode($slug);
        if(empty($stock)){
            session()->flash("error", "Whoops! No record found");
            return back();
        }

        return view("stock.print-request",[
            "stock"=>$stock,
            "plateTypes"=>$this->platetype->getAllPlateTypes(),
            "stockDetails"=> collect( $this->stockrequestdetail->getStockReceiptRecords($stock->sr_id))
        ]);

    }
}
