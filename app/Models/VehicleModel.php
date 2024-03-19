<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class VehicleModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'vm_id';

    public function getVehicleBrand(){
        return $this->belongsTo(VehicleBrand::class, 'vm_brand');
    }

    public function addModel(Request $request){
        $model = new VehicleModel();
        $model->vm_name = $request->modelName ?? '';
        $model->vm_brand = $request->brand ?? '';
        $model->save();
    }
    public function editModel(Request $request){
        $model =  VehicleModel::find($request->modelId);
        $model->vm_name = $request->modelName ?? '';
        $model->vm_brand = $request->brand ?? '';
        $model->save();
    }

    public function getVehicleModels(){
        return VehicleModel::orderBy('vm_name', 'ASC')->get();
    }
    public function getVehicleModelsByBrandId($brandId){
        return VehicleModel::where("vm_brand", $brandId)->orderBy('vm_name', 'ASC')->get();
    }
}
