<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DispenseMloMaster extends Model
{
    use HasFactory;

    public function getAddedBy(){
        return $this->belongsTo(User::class, 'added_by');
    }

    public function getActionedBy(){
        return $this->belongsTo(User::class, 'actioned_by');
    }

    public function getStation(){
        return $this->belongsTo(Station::class, 'mlo_station');
    }

    public function getMlo(){
        return $this->belongsTo(MloSetup::class, 'ms_station');
    }

    public function getDispenseDetails(){
        return $this->hasMany(DispenseMloCart::class, 'dispense_master');
    }

    public function addDispenseMaster($addedBy, $refCode, $mlo, $date){
        $dispense = new DispenseMloMaster();
        $dispense->added_by = $addedBy;
        $dispense->ref_code = $refCode;
        $dispense->mlo_station = $mlo; //this is MLO ID
        $dispense->date_requested = $date ?? now();
        $dispense->save();
        return $dispense;
    }

    public function getDispenseMasterById($id){
        return DispenseMloMaster::find($id);
    }

    public function getDispenseMasterByStatus($status){
        return DispenseMloMaster::where("dispense_status", $status)->orderBy("id", "DESC")->get();
    }
    public function getDispenseMasterByRefCode($refCode){
        return DispenseMloMaster::where("ref_code", $refCode)->first();
    }
}
