<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Lead extends Model
{
    use HasFactory;

    public function getLogs(){
        return $this->hasMany(ActivityLog::class, 'lead_id')->orderBy('id', 'DESC');
    }
    public function getAddedBy(){
        return $this->belongsTo(User::class, 'added_by');
    }
    public function getStatus(){
        return $this->belongsTo(LeadStatus::class, 'status');
    }
    public function getSource(){
        return $this->belongsTo(LeadSource::class, 'source_id');
    }

    public function getLeadNotes(){
        return $this->hasMany(LeadNote::class, 'lead_id')->orderBy('id', 'DESC');
    }
    public function addLead(Request $request):Lead{
        $lead = new Lead();
        $lead->added_by = Auth::user()->id;
        $lead->org_id = Auth::user()->org_id;
        $lead->first_name = $request->firstName;
        $lead->last_name = $request->lastName;
        $lead->email = $request->email;
        $lead->phone = $request->mobileNo;
        $lead->dob = $request->birthDate;
        $lead->source_id = $request->source;
        $lead->status = $request->status;
        $lead->gender = $request->gender;
        $lead->street = $request->street ?? null;
        $lead->city = $request->city ?? null;
        $lead->state = $request->state ?? null;
        $lead->code = $request->code ?? null;
        $lead->slug = Str::slug($request->firstName).'-'.Str::random(8);
        $lead->save();
        return $lead;
    }
    public function editLead(Request $request):Lead{
        $lead =  Lead::find($request->leadId);
        $lead->first_name = $request->firstName;
        $lead->last_name = $request->lastName;
        $lead->email = $request->email;
        $lead->phone = $request->mobileNo;
        $lead->dob = $request->birthDate;
        $lead->source_id = $request->source;
        $lead->status = $request->status;
        $lead->gender = $request->gender;
        $lead->street = $request->street ?? null;
        $lead->city = $request->city ?? null;
        $lead->state = $request->state ?? null;
        $lead->code = $request->code ?? null;
        $lead->slug = Str::slug($request->firstName).'-'.Str::random(8);
        $lead->save();
        return $lead;
    }

    public function getAllOrgLeads(){
        return Lead::where('org_id', Auth::user()->org_id)->orderBy('id', 'DESC')->get();
    }

    public function getLeadBySlug($slug){
        return Lead::where('slug', $slug)->first();
    }

    public function getLeadById($id){
        return Lead::find($id);
    }


}
