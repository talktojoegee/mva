<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceDetail extends Model
{
    use HasFactory;

    public function getProduct(){
        return $this->belongsTo(Product::class, "product_id");
    }
    public function getProductCategory(){
        return $this->belongsTo(ProductCategory::class, "category_id");
    }

    public function setNewInvoiceItem(Request $request, $invoice){
        foreach ($request->product as $key => $item)
        {
            $invoice_item = new InvoiceDetail();
            $invoice_item->invoice_id = $invoice->id;
            $invoice_item->product_id = $item;
            $invoice_item->category_id = $request->productCategory[$key];
            $invoice_item->cost = $request->cost[$key] ?? 0;
            $invoice_item->save();
        }

    }
}
