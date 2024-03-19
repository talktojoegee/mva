<?php

namespace App\Http\Controllers\Portal;

use App\Models\Lga;
use App\Models\MloSetup;
use App\Models\PlateType;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Station;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use Spatie\Permission\Models\Role as SRole;
//use Spatie\Permission\Models\Permission as SPermission;

use App\Http\Controllers\Controller;
use App\Models\AppointmentSetting;
use App\Models\AppointmentType;
use App\Models\ChurchBranch;
use App\Models\Country;
use App\Models\Location;
use App\Models\ModuleManager;
use App\Models\Organization;
use App\Models\Permission;
use App\Models\Region;
use App\Models\Role;
use App\Models\State;
use App\Models\User;
use App\Models\UserNotificationSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->user = new User();
        $this->usernotificationsettings = new UserNotificationSetting();
        $this->appointmentsettings = new AppointmentSetting();
        $this->appointmenttype = new AppointmentType();
        $this->location = new Location();
        $this->country = new Country();
        $this->organization = new Organization();
        $this->churchbranch = new ChurchBranch();
        $this->region = new Region();
        $this->state = new State();
        $this->modulemanager = new ModuleManager();
        $this->permission = new Permission();
        $this->role = new Role();

        $this->lga = new Lga();
        $this->platetype = new PlateType();
        $this->productcategory = new ProductCategory();
        $this->product = new Product();
        $this->station = new Station();
        $this->mlosetup = new MloSetup();
        $this->vehiclebrand = new VehicleBrand();
        $this->vehiclemodel = new VehicleModel();
    }

    public function showSettingsView(){
        return view('settings.settings',[
            'countries'=>$this->country->getCountries()
        ]);
    }


    public function saveAccountSettings(Request $request){
        $this->validate($request,[
            "firstName"=>"required",
            "lastName"=>"required",
            "cellphoneNumber"=>"required",
            "email"=>"required|email",
            "country"=>"required",
            //"state"=>"required",
        ],[
            "firstName.required"=>"Enter your first name",
            "lastName.required"=>"Enter your last name",
            "cellphoneNumber.required"=>"Enter your cellphone number",
            "email.required"=>"Enter your email address",
            "email.email"=>"Enter a valid email address",
            "country.required"=>"Select your country",
            //"state.required"=>"Which state/province are you located in?",
        ]);
        $this->user->updateUserAccount($request);
        if(isset($request->profilePicture)){
            $this->user->uploadProfilePicture($request->profilePicture);
        }
        session()->flash('success', 'Your changes were save!');
        return back();
    }

    public function showNotificationSettings(){
        return view('settings.notification',[
            'notification'=>$this->user->getUserNotificationSettings(Auth::user()->id)
        ]);
    }

    public function saveNotificationSettings(Request $request){
        $this->usernotificationsettings->editDefaultUserNotificationSettings(Auth::user()->id, $request);
        session()->flash("success", "Your notification settings were updated!");
        return back();
    }

    public function showAppointmentSettings(){
        return view('settings.appointments', ['settings'=>$this->appointmentsettings->getUserAppointmentSettings()]);
    }

    public function showChangePasswordForm(){
        return view('settings.change-password');
    }

    public function changePassword(Request $request){
        $this->validate($request,[
            "currentPassword"=>"required",
            "password"=>"required|confirmed|min:6",
        ],[
            "currentPassword.required"=>"Enter your current password",
            "password.required"=>"Choose a new password",
            "password.confirmed"=>"Your re-type password does not match chosen password.",
        ]);
        $user = $this->user->getUserById(Auth::user()->id);
        if (Hash::check($request->currentPassword, $user->password)) {
            $user->password = bcrypt($request->password);
            $user->save();
            session()->flash("success", "Your password was successfully changed.");
            return back();
        }else{
            session()->flash("error", "Current password does not match our record. Try again.");
            return back();
        }
    }

    public function updateAppointmentSettings(Request $request){
        switch ($request->type){
            case 'general-availability':
                $result = $this->appointmentsettings->editGeneralAvailability($request);
                if($result){
                    return response()->json(['message'=>"Your general availability changes were saved!"],200);
                }else{
                    return response()->json(['error'=>"Something went wrong. Try again later"],400);
                }
            case 'appointment-timing':
                $result = $this->appointmentsettings->editAppointmentTiming($request);
                if($result){
                    return response()->json(['message'=>"Your appointment timing changes were saved!"],200);
                }else{
                    return response()->json(['error'=>"Something went wrong. Try again later"]);
                }
            case 'appointment-alerts':
                $result = $this->appointmentsettings->editAppointmentAlerts($request);
                if($result){
                    return response()->json(['message'=>"Your appointment alert changes were saved!"],200);
                }else{
                    return response()->json(['error'=>"Something went wrong. Try again later"]);
                }
            case 'confirmation-cancellation':
                $result = $this->appointmentsettings->editConfirmationCancellation($request);
                if($result){
                    return response()->json(['message'=>"Your confirmation & cancellation changes were saved!"],200);
                }else{
                    return response()->json(['error'=>"Something went wrong. Try again later"]);
                }
            case 'credits':
                $result = $this->appointmentsettings->editCredits($request);
                if($result){
                    return response()->json(['message'=>"Your credits changes were saved!"],200);
                }else{
                    return response()->json(['error'=>"Something went wrong. Try again later"]);
                }
        }


    }


    public function showAppointmentTypeSettings(){
        return view('settings.appointment-types',[
            'appointmentTypes'=>$this->appointmenttype->getAppointmentTypes()
        ]);
    }

    public function storeAppointmentType(Request $request){
        $this->validate($request,[
            "name"=>"required",
            "length"=>"required",
            "allClientBook"=>"required"
        ]);
        $this->appointmenttype->addAppointmentType($request);
        session()->flash("success", "New appointment type registered!");
        return back();
    }


    public function editAppointmentType(Request $request){
        $this->validate($request,[
            "name"=>"required",
            "length"=>"required",
            "allClientBook"=>"required",
            "apptId"=>"required"
        ]);
        $this->appointmenttype->updateAppointmentType($request);
        session()->flash("success", "Your changes were saved!");
        return back();
    }

    public function showApptLocations(){
        return view('settings.appt-locations',[
            'locations'=>$this->location->getAllOrgLocations()
        ]);
    }

    public function storeApptLocations(Request $request){
        $this->validate($request,[
           "locationName"=>"required"
        ],[
            "locationName.required"=>"Enter location name"
        ]);
        $this->location->addLocation($request);
        session()->flash("success", "You've successfully added a new location");
        return back();

    }
  public function editApptLocations(Request $request){
        $this->validate($request,[
           "locationName"=>"required",
            "locationId"=>"required"
        ],[
            "locationName.required"=>"Enter location name"
        ]);
        $this->location->editLocation($request);
        session()->flash("success", "Your changes were saved!");
        return back();

    }

    public function updateOrganizationSettings(Request $request){
        $this->validate($request,[
           "subDomain"=>"required|unique:organizations,sub_domain,".Auth::user()->id,
            "organizationName"=>"required",
            "organizationPhoneNumber"=>"required",
            "organizationEmail"=>"required",
            "addressLine"=>"required",
            "city"=>"required",
            "zipCode"=>"required",
            "orgId"=>"required",
        ],[
            "organizationName.required"=>"What's the name of your organization?",
            "subDomain.required"=>"A custom sub-domain is required",
            "subDomain.unique"=>"This sub-domain is already taken.",
            "organizationPhoneNumber.required"=>"What's the organization's phone number?",
            "organizationEmail.required"=>"What's the organization's email address?",
            "addressLine.required"=>"An address is required",
            "city.required"=>"In which city are you situated?",
            "zipCode.required"=>"What's the region zip code?",
            "orgId.required"=>""
        ]);
        $this->organization->updateOrganizationSettings($request);
        if($request->hasFile('logo')){
            $this->organization->uploadLogo($request->logo);
        }
        if($request->hasFile('favicon')){
            $this->organization->uploadFavicon($request->favicon);
        }
        session()->flash("success", "Your changes were saved!");
        return back();

    }




    public function showCellsSettingsView(){
        return view('settings.settings-cells',[
            'countries'=>$this->country->getCountries()
        ]);
    }

    public function showBranchesSettingsView(){
        $countryId = env('COUNTRY_ID') ?? 1;
        return view('settings.settings-branches',[
            'countries'=>$this->country->getCountries(),
            'branches'=>$this->churchbranch->getAllChurchBranches(),
            'regions'=>$this->region->getRegions(),
            'states'=>$this->state->getStatesByCountryId($countryId)
        ]);
    }

    public function storeChurchBranch(Request $request){
        $this->validate($request,[
            "branchName"=>"required",
            "country"=>"required",
            "state"=>"required",
            "address"=>"required",
            "region"=>"required",
        ],[
            "branchName.required"=>"What will you call this branch?",
            "country.required"=>"Which country is this branch situated?",
            "state.required"=>"Select the state",
            "address.required"=>"Enter address",
            "region.required"=>"Select region",
        ]);
        try{
            $this->churchbranch->addBranch($request);
            session()->flash("success", "You've successfully added a new church branch");
            return back();
        }catch (\Exception $exception){
            session()->flash("error", "Whoops! Something went wrong. Try again later or contact admin.");
            return back();
        }


    }

    public function editChurchBranch(Request $request){
        $this->validate($request,[
            "branchName"=>"required",
            "country"=>"required",
            "state"=>"required",
            "address"=>"required",
            "branchId"=>'required',
            "region"=>'required',
        ],[
            "branchName.required"=>"What will you call this branch?",
            "country.required"=>"Which country is this branch situated?",
            "state.required"=>"Select the state",
            "address.required"=>"Enter address",
            "region.required"=>"Select region",
        ]);
        try{
            $this->churchbranch->editBranch($request);
            session()->flash("success", "Your changes were saved.");
            return back();
        }catch (\Exception $exception){
            session()->flash("error", "Whoops! Something went wrong. Try again later or contact admin.");
            return back();
        }


    }


    public function managePermissions(){
        return view('settings.settings-permissions',[
            'modules'=>$this->modulemanager->getModulesByArea(0),
            'permissions'=>$this->permission->getPermissions(),
        ]);
    }


    public function manageRoles(){
        return view('settings.settings-roles',[
            'roles'=>$this->role->getRoles(),
            'permissions'=>$this->permission->getPermissions(),
        ]);
    }

    public function storeRole(Request $request){
        $all = isset($request->grantAll) ? 1 : 0;
        if($all == 0){
            $this->validate($request,[
                'name'=>'required|unique:roles,name',
                'permission'=>'required|array',
                'permission.*'=>'required',
            ],[
                'name.required'=>'Enter role name',
                'name.unique'=>'Role name already taken',
                'permission.required'=>'Assign at least one permission to this role.',
            ]);
        }else{
            $this->validate($request,[
                'name'=>'required|unique:roles,name',
            ],[
                'name.required'=>'Enter role name',
                'name.unique'=>'Role name already taken',
            ]);
        }
        try {
            if($all == 0){
                $role = SRole::create([
                    'name'=>$request->name,
                    'guard_name'=>'web'
                ]);// $this->role->addRole($request);
                $role->syncPermissions($request->permission);
            }else{
                $permissions = $this->permission->getPermissions()->pluck('id');
                $role = SRole::create([
                    'name'=>$request->name,
                    'guard_name'=>'web'
                ]);// $this->role->addRole($request);
                $role->syncPermissions($permissions);
            }
            session()->flash("success", "Action successful.");
            return back();
        }catch (\Exception $exception){
            session()->flash("error", "Something went wrong. Try again later");
            return back();
        }

    }


    public function updateRolePermissions(Request $request){
        $this->validate($request,[
            'roleId'=>'required'
        ]);
        $role = SRole::findById($request->roleId);
        if(!empty($role)){
            $permissionIds = [];
            foreach($request->permission as $permit){
                array_push($permissionIds, $permit);
            }
            $permissions = $this->permission->getPermissionsByIds($permissionIds);
            //return dd($permissions);
            $role->syncPermissions($permissions);
            session()->flash("success", "Action successful.");
            return back();
        }else{
            session()->flash("error", "Something went wrong. Try again later");
            return back();
        }
    }

    public function storePermission(Request $request){
        $this->validate($request,[
            'permissionName'=>'required',
            'module'=>'required'
        ],[
            'permissionName.required'=>'Enter permission name',
            'module.required'=>'Choose the associate module',
        ]);
        $this->permission->addPermission($request);
        session()->flash("success", "Action successful");
        return back();
    }
    public function editPermission(Request $request){
        $this->validate($request,[
            'permissionName'=>'required',
            'module'=>'required',
            'permissionId'=>'required',
        ],[
            'permissionName.required'=>'Enter permission name',
            'module.required'=>'Choose the associate module',
        ]);
        $this->permission->editPermission($request);
        session()->flash("success", "Your changes were saved.");
        return back();
    }

    public function saveLogo(Request $request){
        $this->validate($request,[
            'logo' => 'required|image|max:1024|mimes:jpg,png,jpeg',
        ],[
            "logo.required"=>"Choose a logo to upload",
            "logo.image"=>"Choose an image file",
            "logo.mimes"=>"Unsupported file format chosen",
        ]);
        $this->organization->uploadLogo($request->logo);
        session()->flash("success", "Your logo was uploaded.");
        return back();
    }
    public function saveFavicon(Request $request){
        $this->validate($request, [
            'favicon' => 'required|image|max:1024|mimes:jpg,png,jpeg',
        ],[
            "favicon.required"=>"Choose a favicon to upload",
            "favicon.image"=>"Choose an image file",
            "favicon.mimes"=>"Unsupported file format chosen",
        ]);
        $this->organization->uploadFavicon($request->favicon);
        session()->flash("success", "Your favicon was uploaded.");
        return back();
    }



    /*
     *
     *
     * Motor Vehicle Administration System Settings
     *
     *
     *
     */

    public function showLGASetupForm(){
        return view('settings.settings-lgas',[
            'lgas'=>$this->lga->getAllLGAs()
        ]);
    }
    public function storeLGA(Request $request){
        $this->validate($request,[
            "lgaName"=>"required",
            "lgaCode"=>"required",
        ],[
            "lgaName.required"=>"What will you call this LGA?",
            "lgaCode.required"=>"Assign a code to this LGA",
        ]);
        try{
            $this->lga->addLGA($request, Auth::user()->id);
            session()->flash("success", "You've successfully added a new LGA code");
            return back();
        }catch (\Exception $exception){
            session()->flash("error", "Whoops! Something went wrong. Try again later or contact admin.");
            return back();
        }


    }

    public function editLGA(Request $request){
        $this->validate($request,[
            "lgaName"=>"required",
            "lgaCode"=>"required",
            "lgaId"=>"required"
        ],[
            "lgaName.required"=>"What will you call this LGA?",
            "lgaCode.required"=>"Assign a code to this LGA",
        ]);
        try{
            $this->lga->editLGA($request);
            session()->flash("success", "Success! Your changes were saved.");
            return back();
        }catch (\Exception $exception){
            session()->flash("error", "Whoops! Something went wrong. Try again later or contact admin.");
            return back();
        }
    }

    public function showPlateTypeView(){
        return view('settings.settings-plate-type',[
            'plates'=>$this->platetype->getAllPlateTypes()
        ]);
    }

    public function storePlateType(Request $request){
        $this->validate($request,[
            "plateType"=>"required",
            "cost"=>"required",
        ],[
            "plateType.required"=>"Plate type is required",
            "cost.required"=>"What's the cost of this plate?",
        ]);
        try{
            $this->platetype->addPlateType($request);
            session()->flash("success", "Action successful!");
            return back();
        }catch (\Exception $exception){
            session()->flash("error", "Whoops! Something went wrong. Try again later or contact admin.");
            return back();
        }


    }


    public function editPlateType(Request $request){
        $this->validate($request,[
            "plateType"=>"required",
            "cost"=>"required",
            "plateId"=>'required'
        ],[
            "plateType.required"=>"Plate type is required",
            "cost.required"=>"What's the cost of this plate?",
        ]);
        try{
            $this->platetype->editPlateType($request);
            session()->flash("success", "Success! Your changes were saved.");
            return back();
        }catch (\Exception $exception){
            session()->flash("error", "Whoops! Something went wrong. Try again later or contact admin.");
            return back();
        }
    }


    public function showProductCategory(){
        return view('settings.settings-product-category',[
            'categories'=>$this->productcategory->getAllOrgProductCategories(),
            'products'=>$this->product->getAllOrgProducts()
            ]);
    }



    public function showStation()
    {
        return view('settings.settings-station',[
            'stations'=>$this->station->getAllStations(),
        ]);
    }

    public function editStation(Request $request){
        $this->validate($request,[
            'stationName'=>'required',
            'stationId'=>'required',
        ],[
            "name.required"=>"What's the name for this station?"
        ]);
        $this->station->editStation($request);
        session()->flash("success", "Your changes were saved!");
        return back();
    }

    public function addStation(Request $request){
        $this->validate($request,[
            'stationName'=>'required',
        ],[
            "stationName.required"=>"Enter station name",
        ]);
        $this->station->addStation($request);
        session()->flash("success", "Your station was added!");
        return back();
    }


    public function showMloSetups(){
        return view('settings.settings-mlo-setup',[
            'mlos'=>$this->mlosetup->getMloSetups(),
            'stations'=>$this->station->getAllStations(),
            'users'=>$this->user->getAllOrgUsersByIsAdmin(1)
        ]);
    }


    public function addMloSetup(Request $request){
        $this->validate($request,[
            "station"=>"required",
            /*"lastName"=>"required",
            "firstName"=>"required",
            "phoneNo"=>"required",
            "email"=>"required",*/
        ],[
            "station.required"=>"Select station from the options provided",
            /*"lastName.required"=>"What's the last name?'",
            "firstName.required"=>"First name is equally important.",
            "phoneNo.required"=>"Let's have the person's phone number",
            "email.required"=>"We need a functional email address to move forward with this.",*/
        ]);
        $user = $this->user->getUserById($request->user);
        if(empty($user)){
            abort(404);
        }
        //$this->mlosetup->addNewMLO($request);
       $mlo =  $this->mlosetup->addRecord($request->station, $user->first_name, $user->last_name ?? null,
            $user->other_names ?? null, $user->email, $user->cellphone_no, $request->mloId);
        $user->mlo_id = $mlo->ms_id;
        $user->save();
        session()->flash("success", "Success! New MLO added to the system.");
        return back();
    }

    public function showVehicleBrands(){
        return view('settings.settings-vehicle-brand',[
            'brands'=>$this->vehiclebrand->getVehicleBrands()
        ]);
    }
    public function showVehicleModels(){
        return view('settings.settings-vehicle-model',[
            'brands'=>$this->vehiclebrand->getVehicleBrands(),
            'models'=>$this->vehiclemodel->getVehicleModels(),
        ]);
    }


    public function addVehicleModel(Request $request){
        $this->validate($request,[
            "modelName"=>"required",
            "brand"=>"required",
        ],[
            "modelName.required"=>"Enter model name",
            "brand.required"=>"Choose brand",
        ]);
        $this->vehiclemodel->addModel($request);
        session()->flash("success", "Success! New vehicle model added to the system.");
        return back();
    }

    public function editVehicleModel(Request $request){
        $this->validate($request,[
            "modelName"=>"required",
            "brand"=>"required",
            "modelId"=>"required"
        ],[
            "modelName.required"=>"Enter model name",
            "brand.required"=>"Choose brand",
        ]);
        $this->vehiclemodel->editModel($request);
        session()->flash("success", "Success! Your changes were saved.");
        return back();
    }

}
