<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleRegDocument extends Model
{
    use HasFactory;
    protected $primaryKey = 'vrd_id';

    public function getDocumentType(){
        return $this->belongsTo(VehicleRegDocumentType::class, "vrd_doc_type");
    }

    public function uploadFiles(Request $request, $regId)
    {
        if ($request->hasFile('document')) {
            foreach($request->document as $key => $attachment){
                $extension = $attachment->getClientOriginalExtension();
                $filename = uniqid() . '_' . time() . '_' . date('Ymd') . '.' . $extension;
                $dir = 'assets/drive/cloud/';
                $attachment->move(public_path($dir), $filename);

                $file = new VehicleRegDocument();
                $file->vrd_doc_type = $request->documentType[$key];
                $file->vrd_doc = $filename;
                $file->vrd_vehicle_reg = $regId;
                $file->save();
            }
        }

    }
}
