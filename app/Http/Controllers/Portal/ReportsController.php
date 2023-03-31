<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\Client;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{

    public $income;
    public function __construct()
    {
        $this->appointment = new Calendar();
        $this->sale = new Sale();
        $this->user = new User();
        $this->client = new Client();

    }

    public function showAppointmentReports(){

        return view('reports.appointment',[
            'appointments'=>$this->appointment->getUserThisYearsAppointments(Auth::user()->id, Auth::user()->org_id),
            'overall'=>$this->appointment->getUserAppointments(Auth::user()->id, Auth::user()->org_id)->count(),
            'search'=>0,
            'from'=>now(),
            'to'=>now()
        ]);
    }

    public function filterAppointments(Request $request){
            $this->validate($request, [
                'filterType'=>'required'
            ]);
            if($request->filterType == 2){
                $this->validate($request,[
                    'from'=>'required|date',
                    'to'=>'required|date'
                ],[
                    'from.required'=>'Choose start period',
                    'from.date'=>'Enter a valid date format',
                    'to.required'=>'Choose end period',
                    'to.date'=>'Enter a valid date format',
                ]);
            }
            if($request->filterType == 1){
                $appointments = $this->appointment->getUserAppointments(Auth::user()->id, Auth::user()->org_id);
                return view('reports.appointment',[
                    'appointments'=>$appointments,
                    'overall'=>$appointments->count(),
                    'search'=>1,
                    'from'=>now(),
                    'to'=>now(),
                    'filterType'=>$request->filterType
                ]);
            }else if($request->filterType == 2){
                $appointments = $this->appointment->getOrgAppointmentsByDateRange($request);
                $overall = $this->appointment->getUserAppointments(Auth::user()->id, Auth::user()->org_id)->count();
                return view('reports.appointment',[
                    'appointments'=>$appointments,
                    'overall'=>$overall,
                    'search'=>1,
                    'from'=>$request->from,
                    'to'=>$request->to,
                    'filterType'=>$request->filterType
                ]);
            }
    }


    public function showRevenueReports(){
        return view('reports.revenue',[
            'search'=>0,
            'from'=>now(),
            'to'=>now(),
            'sales'=>$this->sale->getAllOrgSales(),
        ]);
    }

    public function filterSalesRevenueReport(Request $request){
        $this->validate($request, [
            'filterType'=>'required'
        ]);
        if($request->filterType == 2){
            $this->validate($request,[
                'from'=>'required|date',
                'to'=>'required|date'
            ],[
                'from.required'=>'Choose start period',
                'from.date'=>'Enter a valid date format',
                'to.required'=>'Choose end period',
                'to.date'=>'Enter a valid date format',
            ]);
        }
        if($request->filterType == 1){
            $income = $this->sale->getAllOrgSales();
            return view('reports.revenue',[
                'income'=>$income,
                'search'=>1,
                'from'=>now(),
                'to'=>now(),
                'filterType'=>$request->filterType
            ]);
        }else if($request->filterType == 2){
            $income = $this->sale->getRangeOrgSalesReport($request->from, $request->to);
            $this->income = $this->sale->getSalesStatRange($request->from, $request->to);
            return view('reports.revenue',[
                'income'=>$income,
                'search'=>1,
                'from'=>$request->from,
                'to'=>$request->to,
                'filterType'=>$request->filterType
            ]);
        }
    }

    public function getSalesReportStatistics(){
        $income = $this->sale->getThisYearSalesStat();
        return response()->json(['income'=>$income],200);
    }

    public function getSalesReportStatisticsRange(){
        $income = $this->income;
        if(!empty($income)){
            return response()->json(['income'=>$income],200);
        }else{
            return response()->json(['income'=>$this->sale->getThisYearSalesStat()],200);
        }

    }


    public function showPractitionerReport(){
        return view('reports.practitioner',[
            'practitioners'=>$this->user->getAllOrgUsersByType(2),
            'search'=>0
        ]);
    }

    public function filterPractitionerReport(Request $request){
        $this->validate($request, [
            'filterType'=>'required',
            'practitioner'=>'required',
            'feature'=>'required',
        ],[
            'practitioner.required'=>'Select practitioner to generate report',
            'feature.required'=>'Select feature to generate report',
        ]);
        $orgId = Auth::user()->org_id;
        $practitionerId = $request->practitioner;
        $user = $this->user->getUserById($request->practitioner);
        $from = $request->from;
        $to = $request->to;
        switch($request->feature){
            case 1:
                $this->validateFilterTypeRequest($request);
                $appointments = $request->filterType == 1 ? $this->appointment->getAllPractitionerAppointments($orgId, $practitionerId) : $this->appointment->getAllPractitionerAppointmentsByDateRange($orgId, $practitionerId, $from, $to) ;
                return view('reports.practitioner', [
                    'appointments'=>$appointments,
                    'filterType'=>$request->filterType,
                    'search'=>1,
                    'feature'=>$request->feature,
                    'practitioners'=>$this->user->getAllOrgUsersByType(2),
                    'user'=>$user ?? null,
                    'from'=>$from ?? null,
                    'to'=>$to ?? null
                ]);
            case 2:
                $this->validateFilterTypeRequest($request);
                $income = $request->filterType == 1 ? $this->sale->getAllOrgSalesByPractitioner($practitionerId) : $this->sale->getAllOrgSalesByPractitionerDateRange($practitionerId, $from, $to);
                return view('reports.practitioner', [
                    'sales'=>$income,
                    'filterType'=>$request->filterType,
                    'search'=>1,
                    'feature'=>$request->feature,
                    'practitioners'=>$this->user->getAllOrgUsersByType(2),
                    'user'=>$user ?? null,
                    'from'=>$from ?? null,
                    'to'=>$to ?? null
                ]);
            case 3:
                $this->validateFilterTypeRequest($request);
                $clients = $request->filterType == 1 ? $this->client->getAllMyClients($practitionerId, $orgId) : $this->client->getAllMyClientsDateRange($practitionerId,$orgId, $from, $to);
                return view('reports.practitioner', [
                    'clients'=>$clients,
                    'filterType'=>$request->filterType,
                    'search'=>1,
                    'feature'=>$request->feature,
                    'practitioners'=>$this->user->getAllOrgUsersByType(2),
                    'user'=>$user ?? null,
                    'from'=>$from ?? null,
                    'to'=>$to ?? null
                ]);
            default:
                abort(404);
        }
    }

    public function showClientReport(){
        return view('reports.client',[
            'clients'=>$this->client->getAllOrgClients(Auth::user()->org_id),
            'search'=>0
        ]);
    }

    public function filterClientReport(Request $request){
        $this->validate($request, [
            'filterType'=>'required',
            'practitioner'=>'required',
            'feature'=>'required',
        ],[
            'client.required'=>'Select client to generate report',
            'feature.required'=>'Select feature to generate report',
        ]);
        $orgId = Auth::user()->org_id;
        $clientId = $request->client;
        $client = $this->client->getClientById($request->client);
        $from = $request->from;
        $to = $request->to;
        /*
         * 1=General, 2=Medication, 3=Sales
         */
        switch($request->feature){
            case 1:
                $this->validateFilterTypeRequest($request);
                $appointments = $request->filterType == 1 ? $this->appointment->getAllPractitionerAppointments($orgId, $clientId) : $this->appointment->getAllPractitionerAppointmentsByDateRange($orgId, $clientId, $from, $to) ;
                return view('reports.practitioner', [
                    'appointments'=>$appointments,
                    'filterType'=>$request->filterType,
                    'search'=>1,
                    'feature'=>$request->feature,
                    'practitioners'=>$this->user->getAllOrgUsersByType(2),
                    'user'=>$user ?? null,
                    'from'=>$from ?? null,
                    'to'=>$to ?? null
                ]);
            case 2:
                $this->validateFilterTypeRequest($request);
                $income = $request->filterType == 1 ? $this->sale->getAllOrgSalesByPractitioner($clientId) : $this->sale->getAllOrgSalesByPractitionerDateRange($clientId, $from, $to);
                return view('reports.practitioner', [
                    'sales'=>$income,
                    'filterType'=>$request->filterType,
                    'search'=>1,
                    'feature'=>$request->feature,
                    'practitioners'=>$this->user->getAllOrgUsersByType(2),
                    'user'=>$user ?? null,
                    'from'=>$from ?? null,
                    'to'=>$to ?? null
                ]);
            case 3:
                $this->validateFilterTypeRequest($request);
                $clients = $request->filterType == 1 ? $this->client->getAllMyClients($clientId, $orgId) : $this->client->getAllMyClientsDateRange($clientId,$orgId, $from, $to);
                return view('reports.practitioner', [
                    'clients'=>$clients,
                    'filterType'=>$request->filterType,
                    'search'=>1,
                    'feature'=>$request->feature,
                    'practitioners'=>$this->user->getAllOrgUsersByType(2),
                    'user'=>$user ?? null,
                    'from'=>$from ?? null,
                    'to'=>$to ?? null
                ]);
            default:
                abort(404);
        }
    }

    public function validateFilterTypeRequest(Request $request){
        if($request->filterType == 2){
            $this->validate($request,[
                'from'=>'required|date',
                'to'=>'required|date'
            ],[
                'from.required'=>'Choose start period',
                'from.date'=>'Enter a valid date format',
                'to.required'=>'Choose end period',
                'to.date'=>'Enter a valid date format',
            ]);
        }
    }
}