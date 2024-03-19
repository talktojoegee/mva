<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class MloSetup extends Model
{
    use HasFactory;
    protected $primaryKey = 'ms_id';

    public function getStation(){
        return $this->belongsTo(Station::class, 'ms_station');
    }

    public function addRecord($station, $firstName, $lastName, $otherNames, $email, $phoneNo, $mloId){
        $mlo = new MloSetup();
        $mlo->ms_station = $station;
        $mlo->ms_first_name = $firstName ?? '';
        $mlo->ms_last_name = $lastName ?? '';
        $mlo->ms_other_names = $otherNames ?? '';
        $mlo->ms_email = $email ?? '';
        $mlo->ms_phone_no = $phoneNo ?? '';
        $mlo->ms_mlo_id = $mloId ?? '';
        $mlo->save();
        return $mlo;
    }
    public function addNewMLO(Request $request){
        $mlo = new MloSetup();
        $mlo->ms_station = $request->station;
        $mlo->ms_first_name = $request->firstName ?? '';
        $mlo->ms_last_name = $request->lastName ?? '';
        $mlo->ms_other_names = $request->otherNames ?? '';
        $mlo->ms_email = $request->email ?? '';
        $mlo->ms_phone_no = $request->phoneNo ?? '';
        $mlo->ms_mlo_id = $request->mloId ?? '';
        $mlo->save();
    }

    public function editMLO(Request $request){
        $mlo =  MloSetup::find($request->mloId);
        $mlo->ms_station = $request->station;
        $mlo->ms_first_name = $request->firstName ?? '';
        $mlo->ms_last_name = $request->lastName ?? '';
        $mlo->ms_other_names = $request->otherNames ?? '';
        $mlo->ms_email = $request->email ?? '';
        $mlo->ms_phone_no = $request->phoneNo ?? '';
        $mlo->ms_mlo_id = $request->mloId ?? '';
        $mlo->save();
    }

    public function getMloSetups(){
        return MloSetup::orderBy('ms_id', 'DESC')->get();
    }

    public function getMloById($id){
        return MloSetup::find($id);
    }
}
