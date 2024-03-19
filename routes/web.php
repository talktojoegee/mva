<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/',function(){
    return redirect()->route('login');
})->name('home-redirect');*/
Route::get('/book-appointment', [App\Http\Controllers\Portal\BookingController::class, 'showBookingForm'])->name('book-appointment');


Route::get('/process/payment',[App\Http\Controllers\OnlinePaymentController::class, 'processOnlinePayment']);
Route::prefix('/settings')->group(function(){
   // Route::get('/locations', [App\Http\Controllers\Admin\SettingsController::class, 'locationSetup'])->name('location-setup');
});

Auth::routes();
Route::get('logout', [App\Http\Controllers\Auth\LoginController::class,'logout'])->name('logout');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
//Route::get('/process/payment',[App\Http\Controllers\OnlinePaymentController::class, 'processOnlinePayment']);

Route::get('/home', function(){
    return redirect()->route('settings');
})->name('home');

Route::group(['middleware'=>'auth'], function(){
    Route::get('/dashboard', [App\Http\Controllers\Portal\DashboardController::class, 'showDashboard'])->name('dashboard');
    Route::get('/church-branches', [App\Http\Controllers\Portal\BranchController::class, 'showChurchBranches'])->name('church-branches');
    Route::get('/church-branches/{slug}', [App\Http\Controllers\Portal\BranchController::class, 'showChurchBranchDetails'])->name('church-branch-details');
});

Route::get('/attendance-medication-chart', [App\Http\Controllers\Portal\DashboardController::class, 'getAttendanceMedicationChart'])->name('attendance-medication-chart');

#MV Settings
Route::group(['prefix'=>'/settings', 'middleware'=>'auth'], function(){
    Route::get('/', [App\Http\Controllers\Portal\SettingsController::class, 'showSettingsView'])->name('settings');
    Route::get('/cells', [App\Http\Controllers\Portal\SettingsController::class, 'showCellsSettingsView'])->name('cells-settings');




    Route::get('/lgas', [App\Http\Controllers\Portal\SettingsController::class, 'showLGASetupForm'])->name('lgas-settings');
    Route::post('/lgas', [App\Http\Controllers\Portal\SettingsController::class, 'storeLGA']);
    Route::post('/edit-lga', [App\Http\Controllers\Portal\SettingsController::class, 'editLGA'])->name('edit-lga');
    Route::get('/plate-type', [App\Http\Controllers\Portal\SettingsController::class, 'showPlateTypeView'])->name('plate-type');
    Route::post('/plate-type', [App\Http\Controllers\Portal\SettingsController::class, 'storePlateType']);
    Route::post('/edit-plate-type', [App\Http\Controllers\Portal\SettingsController::class, 'editPlateType'])->name('edit-plate-type');
    Route::get('/product-category', [App\Http\Controllers\Portal\SettingsController::class, 'showProductCategory'])->name('show-product-category');

    Route::get('/stations', [App\Http\Controllers\Portal\SettingsController::class, 'showStation'])->name('mlo-stations');
    Route::post('/add-station', [App\Http\Controllers\Portal\SettingsController::class, 'addStation'])->name('add-station');
    Route::post('/edit-product-category', [App\Http\Controllers\Portal\SettingsController::class, 'editStation'])->name('edit-station');

    Route::get('/mlo-setups', [App\Http\Controllers\Portal\SettingsController::class, 'showMloSetups'])->name('mlo-setups');
    Route::post('/add-mlo-setup', [App\Http\Controllers\Portal\SettingsController::class, 'addMloSetup'])->name('add-mlo-setup');
    //Route::post('/edit-product-category', [App\Http\Controllers\Portal\SettingsController::class, 'editStation'])->name('edit-station');

    Route::get('/vehicle-brands', [App\Http\Controllers\Portal\SettingsController::class, 'showVehicleBrands'])->name('vehicle-brands');
    Route::get('/vehicle-models', [App\Http\Controllers\Portal\SettingsController::class, 'showVehicleModels'])->name('vehicle-models');
    Route::post('/add-vehicle-model', [App\Http\Controllers\Portal\SettingsController::class, 'addVehicleModel'])->name('add-vehicle-model');
    Route::post('/edit-vehicle-model', [App\Http\Controllers\Portal\SettingsController::class, 'editVehicleModel'])->name('edit-vehicle-model');

    Route::get('/branches', [App\Http\Controllers\Portal\SettingsController::class, 'showBranchesSettingsView'])->name('branches-settings');
    Route::post('/branches', [App\Http\Controllers\Portal\SettingsController::class, 'storeChurchBranch']);
    Route::get('/form', [App\Http\Controllers\Portal\SettingsController::class, 'editApptLocations'])->name('edit-appt-locations');
    Route::post('/save-account-settings', [App\Http\Controllers\Portal\SettingsController::class, 'saveAccountSettings'])->name('save-account-settings');
    Route::post('/save-notification-settings', [App\Http\Controllers\Portal\SettingsController::class, 'saveNotificationSettings'])->name('save-notification-settings');
    Route::get('/notifications', [App\Http\Controllers\Portal\SettingsController::class, 'showNotificationSettings'])->name('notification-settings');
    Route::get('/appointments', [App\Http\Controllers\Portal\SettingsController::class, 'showAppointmentSettings'])->name('appointment-settings');
    Route::get('/change-password', [App\Http\Controllers\Portal\SettingsController::class, 'showChangePasswordForm'])->name('change-password');
    Route::post('/change-password', [App\Http\Controllers\Portal\SettingsController::class, 'changePassword']);
    Route::get('/appointment-types', [App\Http\Controllers\Portal\SettingsController::class, 'showAppointmentTypeSettings'])->name('appointment-types-settings');
    Route::post('/appointment-types', [App\Http\Controllers\Portal\SettingsController::class, 'storeAppointmentType']);
    Route::post('/edit-appointment-types', [App\Http\Controllers\Portal\SettingsController::class, 'editAppointmentType'])->name('edit-appointment-types');
    Route::post('/update-appointment-settings', [App\Http\Controllers\Portal\SettingsController::class, 'updateAppointmentSettings'])->name('update-appointment-settings');
    Route::get('/appt-locations', [App\Http\Controllers\Portal\SettingsController::class, 'showApptLocations'])->name('appt-locations');
    Route::post('/appt-locations', [App\Http\Controllers\Portal\SettingsController::class, 'storeApptLocations']);
    Route::post('/edit-appt-locations', [App\Http\Controllers\Portal\SettingsController::class, 'editApptLocations'])->name('edit-appt-locations');
    Route::post('/update-organization-settings', [App\Http\Controllers\Portal\SettingsController::class, 'updateOrganizationSettings'])->name('update-organization-settings');
});

Route::post('/get-vehicle-model', [App\Http\Controllers\Portal\StockController::class, 'getVehicleModel'])->name('get-vehicle-model');
Route::post('/get-number-plate-type', [App\Http\Controllers\Portal\StockController::class, 'getNumberPlateType'])->name('get-number-plate-type');
Route::post('/get-products', [App\Http\Controllers\Portal\VehicleRegController::class, 'getProducts'])->name('get-products');
Route::group(['prefix'=>'/stock'], function(){
    Route::get('/requisition', [App\Http\Controllers\Portal\StockController::class, 'showStockRequisitionForm'])->name('stock-requisition');
    Route::get('/requisition/remove/{itemId}', [App\Http\Controllers\Portal\StockController::class, 'removeItemFromStockRequestDetail'])->name('remove-item-from-list');
    Route::get('/approve-stock-requisition', [App\Http\Controllers\Portal\StockController::class, 'showApproveStockRequisitionForm'])->name('approve-stock-requisition');
    Route::post('/approve-stock-requisition', [App\Http\Controllers\Portal\StockController::class, 'approveStockRequest']);
    Route::get('/print-stock-requisition', [App\Http\Controllers\Portal\StockController::class, 'showPrintStockRequisitionView'])->name('print-stock-requisition');
    Route::get('/print-request/{slug}', [App\Http\Controllers\Portal\StockController::class, 'showPrintRequestView'])->name('print-request');
    Route::post('/submit-new-stock-request', [App\Http\Controllers\Portal\StockController::class, 'newStockRequest'])->name('new-stock-request');
    Route::post('/submit-stock-requisition', [App\Http\Controllers\Portal\StockController::class, 'processStockRequisitionRequest'])->name('submit-stock-requisition');
    Route::get('/stock-details/{slug}', [App\Http\Controllers\Portal\StockController::class, 'showStockRequestDetails'])->name('stock-details');

    #Stock receipt
    Route::get('/stock-receipt', [App\Http\Controllers\Portal\StockController::class, 'showStockReceipt'])->name('stock-receipt');
    Route::post('/upload-stock-receipt', [App\Http\Controllers\Portal\StockController::class, 'uploadStockReceipt'])->name('upload-stock-receipt');
    Route::get('/manage-stock-receipt', [App\Http\Controllers\Portal\StockController::class, 'manageStockReceipt'])->name('manage-stock-receipt');
    Route::get('/stock-receipt-details/{slug}', [App\Http\Controllers\Portal\StockController::class, 'showStockReceiptDetails'])->name('stock-receipt-details');
    Route::post('/approve-stock-receipt', [App\Http\Controllers\Portal\StockController::class, 'approveStockReceipt'])->name('approve-stock-receipt');

    #Dispense to MLO
    Route::get('/dispense-to-mlo', [App\Http\Controllers\Portal\StockController::class, 'showDispenseToMLOView'])->name('dispense-to-mlo');
    Route::post('/dispense-to-mlo', [App\Http\Controllers\Portal\StockController::class, 'processDispenseToMLOCart']);
    Route::post('/remove-item-from-cart', [App\Http\Controllers\Portal\StockController::class, 'removeItemFromCart'])->name('remove-item-from-cart');
    Route::post('/dispense-items-to-mlo', [App\Http\Controllers\Portal\StockController::class, 'dispenseItemsToMLO'])->name('dispense-items-to-mlo');
    Route::get('/approve-dispense-to-mlo-items', [App\Http\Controllers\Portal\StockController::class, 'showApproveDispenseMloView'])->name('approve-dispense-to-mlo-items');
    Route::get('/dispense-to-mlo-items/{slug}', [App\Http\Controllers\Portal\StockController::class, 'showDispenseRequestDetails'])->name('view-dispense-to-mlo-item');
});

Route::group(["prefix"=>"/vehicle"], function(){
   Route::get("/registration", [App\Http\Controllers\Portal\VehicleRegController::class, 'showVehicleRegistrationForm'])->name("vehicle-registration");
    Route::post("/registration", [App\Http\Controllers\Portal\VehicleRegController::class, 'vehicleRegistration']);
    Route::get("/owner-info/{slug}", [App\Http\Controllers\Portal\VehicleRegController::class, 'showVehicleRegistrationOwnerInfoForm'])->name("vehicle-registration-owner-info");
    Route::post("/reg-owner-info", [App\Http\Controllers\Portal\VehicleRegController::class, 'registerOwnerInfo'])->name("reg-owner-info");
    Route::get("/upload-documents/{slug}", [App\Http\Controllers\Portal\VehicleRegController::class, 'showUploadVehicleDocumentsForm'])->name("upload-documents");
    Route::post("/submit-documents", [App\Http\Controllers\Portal\VehicleRegController::class, 'submitDocuments'])->name("submit-documents");
    Route::get("/approve-vehicle-registration", [App\Http\Controllers\Portal\VehicleRegController::class, 'showApproveVehicleRegistration'])->name("approve-vehicle-registration");
    Route::get("/continue-to-payment/{slug}", [App\Http\Controllers\Portal\VehicleRegController::class, 'showContinueToPayment'])->name("continue-to-payment");
    Route::get("/view-vehicle-reg-details/{slug}", [App\Http\Controllers\Portal\VehicleRegController::class, 'showVehicleRegistrationDetails'])->name("view-vehicle-reg-details");

    Route::post("/generate-invoice", [App\Http\Controllers\Portal\VehicleRegController::class, 'generateInvoice'])->name("generate-invoice");
    Route::get("/view-invoice/{slug}", [App\Http\Controllers\Portal\VehicleRegController::class, 'viewInvoice'])->name("view-invoice");
    Route::get("/manage-invoice", [App\Http\Controllers\Portal\VehicleRegController::class, 'manageInvoice'])->name("manage-invoice");
    Route::post("/approve-invoice", [App\Http\Controllers\Portal\VehicleRegController::class, 'approveInvoice'])->name("approve-invoice");
});

Route::post('/get-states', [App\Http\Controllers\Controller::class, 'getStates'])->name('get-states');

Route::group(['prefix'=>'/forms', 'middleware'=>'auth'], function(){
    Route::get('/', [App\Http\Controllers\Portal\FormController::class, 'showForms'])->name('forms');
    Route::get('/form/{slug}', [App\Http\Controllers\Portal\FormController::class, 'showFormDetails'])->name('form-details');
    Route::get('/add-form', [App\Http\Controllers\Portal\FormController::class, 'showAddNewForm'])->name('add-new-form');
    Route::post('/process-form', [App\Http\Controllers\Portal\FormController::class, 'processFormData'])->name('process-form');
});

Route::group(['prefix'=>'/calendar', 'middleware'=>'auth'], function(){
    Route::get('/', [App\Http\Controllers\Portal\CalendarController::class, 'showCalendar'])->name('calendar');
    Route::post('/add-calendar-event', [App\Http\Controllers\Portal\CalendarController::class, 'addCalendarEvent'])->name('add-calendar-event');
    Route::post('/add-group-calendar-event', [App\Http\Controllers\Portal\CalendarController::class, 'addGroupCalendarEvent'])->name('add-group-calendar-event');
    Route::post('/add-calendar-block-event', [App\Http\Controllers\Portal\CalendarController::class, 'addBlockCalendarEvent'])->name('add-calendar-block-event');
    Route::prefix('/appointments')->group(function(){
       Route::get('/', [App\Http\Controllers\Portal\CalendarController::class, 'showAppointments'])->name('show-appointments');
       Route::get('/{slug}', [App\Http\Controllers\Portal\CalendarController::class, 'showAppointmentDetails'])->name('show-appointment-details');
        Route::post('/change-status', [App\Http\Controllers\Portal\CalendarController::class, 'changeStatus'])->name('change-status');
       Route::post('/leave-a-note', [App\Http\Controllers\Portal\CalendarController::class, 'leaveANote'])->name('leave-a-note');
       Route::post('/filter-appointment', [App\Http\Controllers\Portal\CalendarController::class, 'filterAppointment'])->name('filter-appointment');
    });
});

Route::get('/my-notifications', [App\Http\Controllers\Portal\NotificationController::class, 'showMyNotification'])->name('my-notifications')->middleware('auth');
Route::get('/clear-all-notifications', [App\Http\Controllers\Portal\NotificationController::class, 'clearAllNotifications'])->name('clear-all-notifications')->middleware('auth');

Route::prefix('/cloud-storage')->group(function(){
    Route::get('/', [App\Http\Controllers\Portal\CloudStorageController::class, 'showCloudStorage'])->name('cloud-storage');
    Route::post('/manage-files', [App\Http\Controllers\Portal\CloudStorageController::class, 'storeFiles'] )->name('upload-files');
    Route::post('/create-folder', [App\Http\Controllers\Portal\CloudStorageController::class, 'createFolder'] )->name('create-folder');
    Route::get('/folder/{slug}', [App\Http\Controllers\Portal\CloudStorageController::class, 'openFolder'] )->name('open-folder');
    Route::get('/download/{slug}', [App\Http\Controllers\Portal\CloudStorageController::class, 'downloadAttachment'] )->name('download-attachment');
    Route::post('/delete-file', [App\Http\Controllers\Portal\CloudStorageController::class, 'deleteAttachment'])->name('delete-file');
    Route::post('/rename-file', [App\Http\Controllers\Portal\CloudStorageController::class, 'renameAttachment'])->name('rename-file');
    Route::post('/move-file', [App\Http\Controllers\Portal\CloudStorageController::class, 'moveAttachment'])->name('move-file');
    Route::post('/delete-folder', [App\Http\Controllers\Portal\CloudStorageController::class, 'deleteFolder'])->name('delete-folder');
});

Route::group(['prefix'=>'/users', 'middleware'=>'auth'], function(){
    Route::get('/', [App\Http\Controllers\Portal\ClientController::class, 'showClients'])->name('clients');
    Route::post('/user-group', [App\Http\Controllers\Portal\ClientController::class, 'addClientGroup'])->name('client-group');
    Route::post('/edit-user-group', [App\Http\Controllers\Portal\ClientController::class, 'changeClientGroup'])->name('edit-client-group');
    Route::post('/add-user', [App\Http\Controllers\Portal\ClientController::class, 'addClient'])->name('add-client');
    Route::post('/assign-user-to', [App\Http\Controllers\Portal\ClientController::class, 'assignClientTo'])->name('assign-client-to');
    Route::post('/archive-unarchive-user', [App\Http\Controllers\Portal\ClientController::class, 'archiveUnarchiveClient'])->name('archive-unarchive-client');
    Route::post('/edit-user-profile', [App\Http\Controllers\Portal\ClientController::class, 'editClientProfile'])->name('edit-client-profile');
    Route::get('/view-profile/{slug}', [App\Http\Controllers\Portal\ClientController::class, 'viewClientProfile'])->name('view-client-profile');
});


Route::group(['prefix'=>'/tasks', 'middleware'=>'auth'], function(){
    Route::get('/', [App\Http\Controllers\Portal\TaskController::class, 'showTasks'])->name('manage-tasks');
    Route::get('/create', [App\Http\Controllers\Portal\TaskController::class, 'showCreateTaskForm'])->name('create-task');
    Route::post('/create', [App\Http\Controllers\Portal\TaskController::class, 'storeTask']);
    Route::post('/mark-as', [App\Http\Controllers\Portal\TaskController::class, 'markAs'])->name('mark-as');
});


Route::group(['prefix'=>'/products', 'middleware'=>'auth'],function(){
    Route::get('/', [App\Http\Controllers\Portal\SalesnMarketingController::class, 'showAllProducts'])->name('all-products');
    Route::post('/add-product-category', [App\Http\Controllers\Portal\SalesnMarketingController::class, 'addProductCategory'])->name('add-product-category');
    Route::post('/edit-product-category', [App\Http\Controllers\Portal\SalesnMarketingController::class, 'editProductCategory'])->name('edit-product-category');


    Route::post('/add-product-category', [App\Http\Controllers\Portal\SalesnMarketingController::class, 'addProductCategory'])->name('add-product-category');
    Route::post('/edit-product-category', [App\Http\Controllers\Portal\SalesnMarketingController::class, 'editProductCategory'])->name('edit-product-category');

    Route::post('/add-product', [App\Http\Controllers\Portal\SalesnMarketingController::class, 'addProduct'])->name('add-product');
    Route::post('/edit-product', [App\Http\Controllers\Portal\SalesnMarketingController::class, 'editProduct'])->name('edit-product');

    Route::get('/income', [App\Http\Controllers\Portal\SalesnMarketingController::class, 'showIncome'])->name('income');
    Route::post('/record-income', [App\Http\Controllers\Portal\SalesnMarketingController::class, 'recordIncome'])->name('record-income');
    Route::get('/expense', [App\Http\Controllers\Portal\SalesnMarketingController::class, 'showExpense'])->name('expense');
    Route::post('/record-expense', [App\Http\Controllers\Portal\SalesnMarketingController::class, 'recordExpense'])->name('record-expense');
    Route::get('/remittance', [App\Http\Controllers\Portal\SalesnMarketingController::class, 'showRemittance'])->name('remittance');
    Route::get('/show-remittance-collection', [App\Http\Controllers\Portal\SalesnMarketingController::class, 'showRemittanceCollections'])->name('show-remittance-collections');
    Route::post('/process-remittance-request', [App\Http\Controllers\Portal\SalesnMarketingController::class, 'processRemittanceRequest'])->name('process-remittance-request');

   Route::prefix('/reports')->group(function(){
       Route::get('/cashbook/{type}', [App\Http\Controllers\Portal\ReportsController::class, 'showCashbookReport'])->name('cashbook');
       Route::get('/generate-cashbook-report', [App\Http\Controllers\Portal\ReportsController::class, 'generateCashbookReport'])->name('generate-cashbook-report');
       Route::get('/remittance', [App\Http\Controllers\Portal\ReportsController::class, 'showRemittanceReport'])->name('show-remittance-report');
       Route::get('/generate-remittance-report', [App\Http\Controllers\Portal\ReportsController::class, 'generateRemittanceReport'])->name('generate-remittance-report');
   });

    Route::prefix('/marketing')->group(function(){
        Route::get('/dashboard', [App\Http\Controllers\Portal\SalesnMarketingController::class, 'marketing'])->name('marketing-dashboard');
        Route::get('/dashboard-filter', [App\Http\Controllers\Portal\SalesnMarketingController::class, 'filterSalesRevenueReportDashboard'])->name('marketing-dashboard-filter');
        Route::get('/leads', [App\Http\Controllers\Portal\SalesnMarketingController::class, 'showLeads'])->name('leads');
        Route::post('/leads', [App\Http\Controllers\Portal\SalesnMarketingController::class, 'createLead']);
        Route::get('/leads/{slug}', [App\Http\Controllers\Portal\SalesnMarketingController::class, 'leadProfile'])->name('lead-profile');
        Route::post('/leave-lead-note', [App\Http\Controllers\Portal\SalesnMarketingController::class, 'leaveLeadNote'])->name('leave-lead-note');
        Route::post('/edit-lead-note', [App\Http\Controllers\Portal\SalesnMarketingController::class, 'editLeadNote'])->name('edit-lead-note');
        Route::post('/delete-lead-note', [App\Http\Controllers\Portal\SalesnMarketingController::class, 'deleteLeadNote'])->name('delete-lead-note');
        Route::get('/messaging', [App\Http\Controllers\Portal\SalesnMarketingController::class, 'showMessaging'])->name('marketing-messaging');
        Route::get('/compose-messaging', [App\Http\Controllers\Portal\SalesnMarketingController::class, 'showComposeMessaging'])->name('marketing-compose-messaging');
        Route::post('/compose-messaging', [App\Http\Controllers\Portal\SalesnMarketingController::class, 'storeMessage']);
        Route::get('/automations', [App\Http\Controllers\Portal\SalesnMarketingController::class, 'showAutomations'])->name('marketing-automations');
        Route::get('/create-automation', [App\Http\Controllers\Portal\SalesnMarketingController::class, 'showCreateAutomation'])->name('marketing-create-automation');
        Route::post('/create-automation', [App\Http\Controllers\Portal\SalesnMarketingController::class, 'storeAutomation']);
        Route::get('/edit-marketing-automation/{slug}', [App\Http\Controllers\Portal\SalesnMarketingController::class, 'showEditAutomationForm'])->name('edit-marketing-automation');
        Route::post('/save-marketing-automation-changes', [App\Http\Controllers\Portal\SalesnMarketingController::class, 'editAutomation'])->name('save-marketing-automation-changes');
    });

});

Route::group(['prefix'=>'/attendance', 'middleware'=>'auth'], function(){
    Route::get('/', [App\Http\Controllers\Portal\CalendarController::class, 'showAttendance'])->name('attendance');
    Route::post('/', [App\Http\Controllers\Portal\CalendarController::class, 'publishAttendance']);
    Route::post('/edit-attendance', [App\Http\Controllers\Portal\CalendarController::class, 'publishAttendance'])->name('edit-attendance');
    Route::get('/chart-attendance', [App\Http\Controllers\Portal\CalendarController::class, 'getAttendanceChart'])->name('chart-attendance');
});

Route::group(['prefix'=>'workflow', 'middleware'=>'auth'], function(){
    Route::get('/', [App\Http\Controllers\Portal\WorkflowController::class, 'showWorkflowView'])->name('workflow');
    Route::post('/', [App\Http\Controllers\Portal\WorkflowController::class, 'storeWorkflowRequest']);
    Route::get('/{slug}', [App\Http\Controllers\Portal\WorkflowController::class, 'viewWorkflowRequest'])->name('view-workflow');
    Route::post('/comment-on-post', [App\Http\Controllers\Portal\WorkflowController::class, 'commentOnPost'])->name('comment-on-post');
    Route::post('/update-workflow', [App\Http\Controllers\Portal\WorkflowController::class, 'updateWorkflowStatus'])->name('update-workflow');

});

Route::group(['prefix'=>'newsfeed', 'middleware'=>'auth'], function(){
   Route::get('/', [App\Http\Controllers\Portal\TimelineController::class, 'showTimeline'])->name('timeline');
   Route::post('/publish-timeline-post', [App\Http\Controllers\Portal\TimelineController::class, 'storeTimelinePost'])->name('publish-timeline-post');
   Route::get('/post/{slug}', [App\Http\Controllers\Portal\TimelineController::class, 'readTimelinePost'])->name('read-timeline-post');
});

Route::group(['prefix'=>'/bulk-sms', 'middleware'=>'auth'],function(){
    //Route::get('/', [App\Http\Controllers\UserController::class, 'customerDashboard'])->name('customer-dashboard');
    Route::get('/fund-wallet', [App\Http\Controllers\Portal\SMSController::class, 'showTopUpForm'])->name('top-up');
    Route::post('/fund-wallet', [App\Http\Controllers\Portal\SMSController::class, 'processTopUpRequest']);
    Route::get('/fund-wallet/transactions', [App\Http\Controllers\Portal\SMSController::class, 'showTopUpTransactions'])->name('top-up-transactions');
    Route::get('/compose-sms', [App\Http\Controllers\Portal\SMSController::class, 'showComposeMessageForm'])->name('compose-sms');
    Route::get('/preview-message',[App\Http\Controllers\Portal\SMSController::class, 'previewMessage'])->name('preview-message');
    Route::post('/send-text-message',[App\Http\Controllers\Portal\SMSController::class, 'sendTextMessage'])->name('send-text-message');

    Route::get('/schedule-sms', [App\Http\Controllers\Portal\SMSController::class, 'showScheduleSmsForm'])->name('schedule-sms');
    Route::get('/api-settings', [App\Http\Controllers\Portal\SMSController::class, 'showApiInterface'])->name('api-settings');

    Route::get('/senders/create', [App\Http\Controllers\Portal\SMSController::class, 'showSenderIdForm'])->name('create-senders');
    Route::post('/senders/create', [App\Http\Controllers\Portal\SMSController::class, 'createSenderId']);
    Route::get('/senders/registered', [App\Http\Controllers\Portal\SMSController::class, 'showRegisteredSenderIds'])->name('registered-senders');

    Route::get('/phone-groups',[App\Http\Controllers\Portal\SMSController::class, 'showPhoneGroupForm'])->name('phone-groups');
    Route::post('/phone-groups',[App\Http\Controllers\Portal\SMSController::class, 'setNewPhoneGroup']);
    Route::post('/edit-phone-group',[App\Http\Controllers\Portal\SMSController::class, 'setNewPhoneGroup'])->name('edit-phone-group');

    Route::get('/batch-report', [App\Http\Controllers\Portal\SMSController::class, 'batchReport'])->name('batch-report');

    //Route::post('/regenerate-api-token',[App\Http\Controllers\UserController::class, 'reGenerateApiToken'])->name('regenerate-api-token');
});


Route::group(['prefix'=>'/reports', 'middleware'=>'auth'],function(){
    Route::get('/appointments', [App\Http\Controllers\Portal\ReportsController::class, 'showAppointmentReports'])->name('appointment-reports');
    Route::get('/filter-appointment-reports', [App\Http\Controllers\Portal\ReportsController::class, 'filterAppointments'])->name('filter-appointment-reports');
    Route::get('/revenues', [App\Http\Controllers\Portal\ReportsController::class, 'showRevenueReports'])->name('show-revenue-reports');
    Route::get('/revenue-statistics', [App\Http\Controllers\Portal\ReportsController::class, 'getSalesReportStatistics'])->name('revenue-statistics');
    Route::get('/revenue-statistics-range', [App\Http\Controllers\Portal\ReportsController::class, 'getSalesReportStatisticsRange'])->name('revenue-statistics-range');
    Route::get('/filter-sales-report', [App\Http\Controllers\Portal\ReportsController::class, 'filterSalesRevenueReport'])->name('filter-sales-report');
    Route::get('/practitioners', [App\Http\Controllers\Portal\ReportsController::class, 'showPractitionerReport'])->name('practitioner-report');
    Route::get('/filter-practitioner-report', [App\Http\Controllers\Portal\ReportsController::class, 'filterPractitionerReport'])->name('filter-practitioner-report');
    Route::get('/clients', [App\Http\Controllers\Portal\ReportsController::class, 'showClientReport'])->name('client-report');

});

Route::group(['prefix'=>'/follow-up', 'middleware'=>'auth'], function(){
    Route::post('/add-follow-up', [App\Http\Controllers\Portal\MedicationController::class, 'addMedication'])->name('add-medication');
    Route::post('/edit-follow-up', [App\Http\Controllers\Portal\MedicationController::class, 'editMedication'])->name('edit-medication');
    Route::get('/follow-up-details/{slug}', [App\Http\Controllers\Portal\MedicationController::class, 'showMedicationDetails'])->name('medication-details');
    Route::post('/follow-up-report', [App\Http\Controllers\Portal\MedicationController::class, 'submitMedicationReport'])->name('medication-report');
});

Route::group(['prefix'=>'/website', 'middleware'=>'auth'], function(){
    Route::get('/homepage', [App\Http\Controllers\Portal\WebsiteController::class, 'showWebsiteHomepage'])->name('website-homepage');
    Route::get('/settings', [App\Http\Controllers\Portal\WebsiteController::class, 'showWebsiteSettings'])->name('website-settings');
    Route::get('/forms', [App\Http\Controllers\Portal\WebsiteController::class, 'showWebsiteForms'])->name('website-forms');
    Route::get('/create-form', [App\Http\Controllers\Portal\WebsiteController::class, 'showCreateWebsiteForm'])->name('create-website-form');
    Route::post('/create-form', [App\Http\Controllers\Portal\WebsiteController::class, 'CreateWebsiteForm']);
    Route::get('/edit-form/{slug}', [App\Http\Controllers\Portal\WebsiteController::class, 'showEditWebsiteForm'])->name('edit-website-form');
    Route::get('/view-form/{slug}', [App\Http\Controllers\Portal\WebsiteController::class, 'viewWebsiteForm'])->name('view-website-form');
    Route::get('/web-pages', [App\Http\Controllers\Portal\WebsiteController::class, 'showOrgWebpages'])->name('web-pages');
    Route::get('/web-pages/create', [App\Http\Controllers\Portal\WebsiteController::class, 'showCreateWebPageForm'])->name('create-web-page');
    Route::post('/web-pages/create', [App\Http\Controllers\Portal\WebsiteController::class, 'CreateWebPage']);
    Route::post('/web-pages/homepage-settings', [App\Http\Controllers\Portal\WebsiteController::class, 'updateHomepageSettings'])->name('website-homepage-settings');
    Route::post('/web-pages/add-service', [App\Http\Controllers\Portal\WebsiteController::class, 'addService'])->name('add-website-service');
    Route::post('/web-pages/edit-service', [App\Http\Controllers\Portal\WebsiteController::class, 'editService'])->name('edit-website-service');
});

Route::group(['prefix'=>'/newsfeed', 'middleware'=>'auth'], function(){

});

Route::group(['prefix'=>'/users', 'middleware'=>'auth'], function(){
    Route::get('/practitioners', [App\Http\Controllers\UserController::class, 'showPractitioners'])->name('practitioners');
    Route::get('/', [App\Http\Controllers\UserController::class, 'showAdministrators'])->name('pastors');
    Route::get('/user/add-new', [App\Http\Controllers\UserController::class, 'showAddNewPastorForm'])->name('add-new-pastor');
    Route::get('/{slug}', [App\Http\Controllers\UserController::class, 'showUserProfile'])->name('user-profile');
    Route::post('/assign-revoke-role', [App\Http\Controllers\UserController::class, 'assignRevokeRole'])->name('assign-revoke-role');
    Route::post('/add-new-user', [App\Http\Controllers\UserController::class, 'addNewUser'])->name('add-new-user');
    Route::post('/delete-user', [App\Http\Controllers\UserController::class, 'deleteUser'])->name('delete-user');
    Route::post('/grant-permission', [App\Http\Controllers\UserController::class, 'grantPermission'])->name('grant-permission');
});


Route::group(['prefix'=>'/accounting', 'middleware'=>'auth', 'as'=>'accounting.'], function(){

    Route::get('/categories', [App\Http\Controllers\Portal\AccountingController::class, 'showManageCategories'])->name('categories');
    Route::post('/categories', [App\Http\Controllers\Portal\AccountingController::class, 'addTransactionCategory']);
    Route::post('/edit-category', [App\Http\Controllers\Portal\AccountingController::class, 'editTransactionCategory'])->name('edit-category');
    Route::get('/chart-of-accounts', [App\Http\Controllers\Portal\AccountingController::class, 'showChartOfAccounts'])->name('chart-of-accounts');
    Route::get('/add-new-account', [App\Http\Controllers\Portal\AccountingController::class, 'showCreateChartOfAccountForm'])->name('add-new-account');
    Route::post('/add-new-account', [App\Http\Controllers\Portal\AccountingController::class, 'saveAccount']);
    Route::post('/get-account-type', [App\Http\Controllers\Portal\AccountingController::class, 'getParentAccount'])->name('get-account-type');
    Route::get('/journal-voucher', [App\Http\Controllers\Portal\AccountingController::class, 'showJournalVoucherForm'])->name('journal-voucher');

    #Cashbook routes
    Route::get('/accounts', [App\Http\Controllers\Portal\CashbookController::class, 'showManageAccounts'])->name('accounts');
    Route::post('/accounts', [App\Http\Controllers\Portal\CashbookController::class, 'addCashBook']);
});

Route::group(['prefix'=>'app', 'middleware'=>'auth'],function(){
    Route::prefix('/settings')->group(function(){
        Route::get('/church', \App\Http\Livewire\Portal\Settings\Organization::class)->name('organization');
        Route::get('/account', \App\Http\Livewire\Portal\Settings\Account::class)->name('account-settings');
        Route::get('/module-manager', \App\Http\Livewire\Portal\Settings\ModuleManager::class)->name('module-manager');
        Route::get('/manage-roles', [App\Http\Controllers\Portal\SettingsController::class, 'manageRoles'])->name('manage-roles');
        Route::post('/add-role', [App\Http\Controllers\Portal\SettingsController::class, 'storeRole'])->name('add-role');
        Route::post('/update-role-permissions', [App\Http\Controllers\Portal\SettingsController::class, 'updateRolePermissions'])->name('update-role-permissions');
        Route::post('/add-permission', [App\Http\Controllers\Portal\SettingsController::class, 'storePermission'])->name('add-permission');
        Route::post('/edit-permission', [App\Http\Controllers\Portal\SettingsController::class, 'editPermission'])->name('edit-permission');
        Route::get('/manage-permissions', [App\Http\Controllers\Portal\SettingsController::class, 'managePermissions'])->name('manage-permissions');
        Route::post('/save-logo', [App\Http\Controllers\Portal\SettingsController::class, 'saveLogo'])->name('save-logo');
        Route::post('/save-favicon', [App\Http\Controllers\Portal\SettingsController::class, 'saveFavicon'])->name('save-favicon');
        Route::get('/purchase-or-upgrade-plan', \App\Http\Livewire\Portal\Settings\PurchaseUpgradePlan::class)->name('purchase-or-upgrade-plan');
    });
});
//Route::get('/', [App\Http\Controllers\Controller::class, 'showOrganizationPageDetails'])->name('homepage');


//Route::get('/', [App\Http\Controllers\Controller::class, 'homepage'])->name('homepage');
Route::get('/', function(){
    return redirect()->route('login');
})->name('homepage');


Route::group(['domain'=>'{account}.'.env('APP_URL')],function(){
    Route::get('/', function(){
        return "Thanks";
    })->name('org-homepage');
    Route::post('/process-frontend-form', [App\Http\Controllers\Controller::class, 'processFrontendForm'])->name('process-frontend-form');
    Route::get('/contact-us', [App\Http\Controllers\Controller::class, 'contactUs'])->name('contact-org');
});

//Route::group(['prefix'=>'super-channel', 'middleware'=>'is_admin'],function(){
    //Route::get('/', [App\Http\Controllers\AdminController::class, 'adminDashboard'])->name('admin-dashboard');
//});

/*
 * You'll need a team to run the race of life faithfully. We offer ourselves to be that family you can hold unto.
 */


/*DB::beginTransaction();
try {
    $this->pippo();
} catch (\Exception $ex) {
    DB::rollback();
}
DB::commit();

public function pippo(){
    $type=Cga_type::create(['name'=>'vvvv','description'=>'yyy']);
    throw new Exception('error');

}*/
