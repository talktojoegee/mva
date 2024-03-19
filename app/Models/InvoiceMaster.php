<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceMaster extends Model
{
    use HasFactory;

    public function getVehicle(){
        return $this->belongsTo(VehicleReg::class, "vehicle_reg_id");
    }

    public function getInvoiceDetails(){
        return $this->hasMany(InvoiceDetail::class, "invoice_id");
    }


    public function newInvoice(Request $request, $total){
        $invoice = new InvoiceMaster();
        $invoice->issued_by = Auth::user()->id;
        $invoice->issue_date = $request->issueDate ?? now();
        $invoice->due_date = $request->dueDate ?? now();
        $invoice->ref_code = substr(sha1(time()),30,40);
        $invoice->total = $total ?? 0;
        $invoice->slug = substr(sha1(time()),21,40);
        $invoice->vehicle_reg_id = $request->vehicleReg ?? null;
        $invoice->save();
        return $invoice;
    }

    public function getInvoiceById($id){
        return InvoiceMaster::find($id);
    }

    public function getInvoiceBySlug($slug){
        return InvoiceMaster::where("slug",$slug)->first();
    }

    public function getAllInvoices(){
        return InvoiceMaster::orderBy("id", "DESC")->get();
    }
}
