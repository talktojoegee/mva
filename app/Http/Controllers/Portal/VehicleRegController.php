<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\InvoiceDetail;
use App\Models\InvoiceMaster;
use App\Models\PlateType;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\StockReceiptDetail;
use App\Models\VehicleBrand;
use App\Models\VehicleColor;
use App\Models\VehicleModel;
use App\Models\VehicleReg;
use App\Models\VehicleRegDocument;
use App\Models\VehicleRegDocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleRegController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
        $this->vehiclebrand = new VehicleBrand();
        $this->vehiclemodel = new VehicleModel();
        $this->vehiclereg = new VehicleReg();
        $this->vehiclecolor = new VehicleColor();
        $this->platetype = new PlateType();
        $this->vehicleregdoctype = new VehicleRegDocumentType();
        $this->vehicleregdoc = new VehicleRegDocument();
        $this->stockreceiptdetail = new StockReceiptDetail();
        $this->productcategory = new ProductCategory();
        $this->product = new Product();
        $this->invoicemaster = new InvoiceMaster();
        $this->invoicedetail = new InvoiceDetail();

    }


    public function showVehicleRegistrationForm(){
        return view("vehicle.vehicle-registration",[
            "colors"=>$this->vehiclecolor->getAllColors(),
            "brands"=>$this->vehiclebrand->getVehicleBrands(),
            "plateTypes"=>$this->platetype->getAllPlateTypes()
        ]);
    }


    public function vehicleRegistration(Request $request){
        $this->validate($request,[
            "date"=>"required|date",
            "vehicleBrand"=>"required",
            "vehicleModel"=>"required",
            "vehicleColor"=>"required",
            "chassisNo"=>"required",
            "engineNo"=>"required",
            "engineCapacity"=>"required",
            "plateNo"=>"required",
        ],[
            "date.required"=>"Enter vehicle registration date",
            "date.date"=>"Enter a valid date",
            "vehicleBrand.required"=>"Select vehicle brand",
            "vehicleModel.required"=>"Select vehicle model",
            "vehicleColor.required"=>"Select vehicle color",
            "chassisNo.required"=>"Enter chassis number",
            "engineNo.required"=>"Enter engine number",
            "engineCapacity.required"=>"Enter engine capacity",
            "plateNo.required"=>"Choose plate number",
        ]);
        $record = $this->vehiclereg->addRecord($request);
        //update stock receipt detail
        $details = $this->stockreceiptdetail->getStockReceiptDetailByPlateNo($request->plateNo);
        if(!empty($details)){
            $details->locked = 1;
            $details->save();
        }
        session()->flash("success", "Success! Action successful");
        return redirect()->route("vehicle-registration-owner-info", $record->vr_slug);
    }


    public function showVehicleRegistrationOwnerInfoForm($slug){
        $record = $this->vehiclereg->getVehicleRegBySlug($slug);
        if(empty($record)){
            abort(404);
        }
        return view("vehicle.vehicle-registration-owner-info",[
            "record"=>$record
        ]);

    }

    public function registerOwnerInfo(Request $request){
        $this->validate($request,[
            "ownersName"=>"required",
            "ownersAddress"=>"required",
            "ownersEmail"=>"required|email",
            "ownersTelephone"=>"required",
            "ownersNIN"=>"required",
            "slug"=>"required",
        ],[
            "ownersName.required"=>"Enter Owner's name",
            "ownersAddress.required"=>"Enter Owner's address",
            "ownersEmail.required"=>"Enter Owner's email",
            "ownersEmail.email"=>"Enter a valid email address",
            "ownersTelephone.required"=>"Enter Owner's telephone",
            "ownersNIN.required"=>"Enter Owner's NIN",
        ]);
        $record = $this->vehiclereg->getVehicleRegBySlug($request->slug);
        if(empty($record)){
            abort(404);
        }
        $this->vehiclereg->updateVehicleOwnerInfo($record->vr_id, $request->ownersName ?? '', $request->ownersAddress ?? '',
            $request->ownersTelephone ?? '', $request->ownersEmail ?? '', $request->ownersNIN ?? '');
        session()->flash("success", "Success! Personal Details saved. Proceed to upload documents");
        return redirect()->route("upload-documents", $record->vr_slug);

    }

    public function showApproveVehicleRegistration(){
        return view("vehicle.approve-vehicle-registration",[
            "records"=>$this->vehiclereg->getAllVehicleRegistrations()
        ]);
    }


    public function showVehicleRegistrationDetails($slug){
        $record = $this->vehiclereg->getVehicleRegBySlug($slug);
        if(empty($record)){
            abort(404);
        }

        return view("vehicle.view-vehicle-reg-details",[
            "record"=>$record
        ]);
    }

    public function showUploadVehicleDocumentsForm($slug){
        $record = $this->vehiclereg->getVehicleRegBySlug($slug);
        if(empty($record)){
            abort(404);
        }

        return view("vehicle.vehicle-registration-document-upload",[
            "record"=>$record,
            "documentTypes"=>$this->vehicleregdoctype->getDocumentTypes()
        ]);
    }


    public function submitDocuments(Request $request){
        $this->validate($request,[
            "document"=>"required|array",
            "documentType"=>"required|array",
            "document.*"=>"required",
            "documentType.*"=>"required",
            "slug"=>"required",
        ],[
            "document.required"=>"Choose a document to upload",
            "documentType.required"=>"Indicate document type",
        ]);
        $record = $this->vehiclereg->getVehicleRegBySlug($request->slug);
        if(empty($record)){
            abort(404);
        }
        $this->vehicleregdoc->uploadFiles($request, $record->vr_id);
        session()->flash("success", "Success! Proceed to make payment");
        return redirect()->route("continue-to-payment", $record->vr_slug);
    }


    public function showContinueToPayment($slug){
        $record = $this->vehiclereg->getVehicleRegBySlug($slug);
        if(empty($record)){
            abort(404);
        }

        return view("vehicle.vehicle-registration-payment",[
            "record"=>$record,
            "documentTypes"=>$this->vehicleregdoctype->getDocumentTypes(),
            "productCategories"=>$this->productcategory->getAllOrgProductCategories()
        ]);
    }


    public function getProducts(Request $request){
        $catId = $request->categoryId;
        $products = $this->product->getProductsByCatId($catId);
        return view("vehicle.partials._products",[
            "products"=>$products
        ]);
    }

    public function generateInvoice(Request $request){
        $this->validate($request,[
            "issueDate"=>"required|date",
            "dueDate"=>"required|date",
            "product"=>"required|array",
            "productCategory"=>"required|array",
            "productCategory.*"=>"required",
            "product.*"=>"required",
            "cost"=>"required|array",
            "cost.*"=>"required",
            "vehicleReg"=>"required",
        ]);
        $total = 0;
        foreach($request->cost as $cost){
            $total += $cost;
        }
       $invoice =  $this->invoicemaster->newInvoice($request, $total);
        $this->invoicedetail->setNewInvoiceItem($request, $invoice);
        session()->flash("success", "Success! Invoice generated.");
        return redirect()->route("view-invoice", $invoice->slug);
    }


    public function viewInvoice($slug){
        $invoice = $this->invoicemaster->getInvoiceBySlug($slug);
        if(empty($invoice)){
            abort(404);
        }
        return view("vehicle.invoice",[
            "invoice"=>$invoice
        ]);
    }

    public function manageInvoice(){
        return view("vehicle.invoice-list",[
            "invoices"=>$this->invoicemaster->getAllInvoices()
        ]);
    }

    public function approveInvoice(Request $request){
        $this->validate($request,[
            "invoice"=>"required"
        ]);
        $invoice = $this->invoicemaster->getInvoiceById($request->invoice);
        if(empty($invoice)){
            abort(404);
        }
        $invoice->approved_by = Auth::user()->first_name ." ".Auth::user()->last_name;
        $invoice->approved_date = now();
        $invoice->status = 1;
        $invoice->save();
        session()->flash("success", "Success! Invoice approved.");
        return redirect()->route("view-invoice", $invoice->slug);
    }
}
