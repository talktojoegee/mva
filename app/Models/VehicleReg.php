<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleReg extends Model
{
    use HasFactory;
    protected $primaryKey = "vr_id";


    public function getVehicleBrand(){
        return $this->belongsTo(VehicleBrand::class, "vr_brand");
    }

    public function getVehicleModel(){
        return $this->belongsTo(VehicleModel::class, "vr_model");
    }

    public function getVehicleColor(){
        return $this->belongsTo(VehicleColor::class, "vr_color");
    }

    public function getStation(){
        return $this->belongsTo(Station::class, "vr_station");
    }
    public function getMlo(){
        return $this->belongsTo(MloSetup::class, "vr_mlo");
    }

    public function getVehicleRegDocuments(){
            return $this->hasMany(VehicleRegDocument::class, "vrd_vehicle_reg");
        }

    public function getPlateType(){
        return $this->belongsTo(PlateType::class, "vr_plate_type");
    }

    public function addRecord(Request $request){
        $record = new VehicleReg();
        $record->vr_registered_by = Auth::user()->id;
        $record->vr_date = now();
        $record->vr_brand = $request->vehicleBrand ?? '';
        $record->vr_model = $request->vehicleModel ?? '';
        $record->vr_color = $request->vehicleColor ?? '';
        $record->vr_chassis_no = $request->chassisNo ?? '';
        $record->vr_engine_no = $request->engineNo ?? '';
        $record->vr_engine_capacity = $request->engineCapacity ?? '';
        $record->vr_plate_no = $request->plateNo ?? '';
        $record->vr_reg_level = 1; //level one done
        $record->vr_plate_type = $request->plateType ?? null;
        $record->vr_slug = substr(sha1(time()),21,40);
        $record->vr_station = Auth::user()->getMloDetails->getStation->id ?? null;
        $record->vr_mlo = Auth::user()->getMloDetails->ms_id ?? null;
        $record->save();
        return $record;
    }

    public function getVehicleRegBySlug($slug){
        return VehicleReg::where("vr_slug", $slug)->first();
    }


    public function updateVehicleOwnerInfo($recordId, $ownerName, $ownerAddress, $ownerTelephone, $ownerEmail, $ownerNin){
        $record = VehicleReg::find($recordId);
        $record->vr_new_owner_name = $ownerName ?? null;
        $record->vr_new_owner_email = $ownerEmail ?? null;
        $record->vr_new_owner_mobile_no = $ownerTelephone ?? null;
        $record->vr_new_owner_nin = $ownerNin ?? null;
        $record->vr_new_owner_address = $ownerAddress ?? null;
        $record->vr_reg_level = 2 ; //second phase reg done
        $record->save();
    }


    public function getAllVehicleRegistrations(){
        return VehicleReg::orderBy("vr_id", "DESC")->get();
    }
}
