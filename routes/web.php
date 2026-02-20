<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\LeaveFormController;
use App\Http\Controllers\OvertimesController;
use App\Http\Controllers\ReimbursementController;
use App\Http\Controllers\ViewLeavesController;

use App\Http\Controllers\CalenderController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ProcessController;


/* E-Forms */
use App\Http\Livewire\EForms\LeaveApplication;
use App\Http\Livewire\EForms\OvertimeRequests;
use App\Http\Livewire\EForms\WorkFromHome;
/* Records Management */
use App\Http\Livewire\RecordsManagement\Timelogs;
use App\Http\Livewire\RecordsManagement\Employees;
use App\Http\Livewire\RecordsManagement\AttendanceMonitoring;
use App\Http\Livewire\ServerStatus;
use App\Http\Livewire\AdminDashboard;
/* Setup */
use App\Http\Livewire\Setup\AuthorizeView;
use App\Http\Livewire\Setup\UserManagement\UserGroups;
use App\Http\Livewire\Setup\ModuleCreation;
use App\Http\Livewire\Benefits\LeaveCredits;

use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\HRManagementController;
use App\Http\Controllers\ClearancesController;

use App\Http\Controllers\OfficesController;
use App\Http\Controllers\HRMemoController;

use App\Http\Controllers\CountriesController;

use App\Http\Controllers\FullCalenderController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PageController;

use App\Http\Controllers\CKEditorController;

use App\Http\Controllers\PusherNotificationController;

use App\Http\Controllers\WebcamController;
use App\Http\Controllers\QRCodeController;

use App\Http\Controllers\PersonalDataSheetController;
use App\Http\Controllers\PersonnelAccountingDataController;


/* FACE RECOGNITION */
use App\Http\Livewire\RecordsManagement\FaceRegistration;
use App\Http\Controllers\FaceRegistrationController;

/* CRON / SCHEDULER */
use App\Http\Controllers\CronController;

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

Route::get('/', function () {
    if (Auth::check() && Auth::user()->email_verified_at != NULL) {
        return redirect('/dashboard');
    } else {
        return redirect('/login');
    }
});

Route::get('/emp-val/{qrLink}', [QRCodeController::class, 'qrCodeProfile'])->name('qr-code-profile');

Route::middleware(['auth:sanctum', 'verified', 'checkServerStatus'])->group(function () {

    Route::get('/dashboard', function () {
        if (Auth::user()->id == 1) {
            // return view('dashboard-admin');
            return redirect('/admin-dashboard');
        } else {
            return view('dashboard');
        }
    })->name('dashboard');

    Route::get('/admin-dashboard', AdminDashboard::class)->name('admin.dashboard');

    /*======= E-LEAVE APPLICATION ======*/
    Route::get('/e-forms/leaves-listing', LeaveApplication::class)->name('eforms.leaves-listing');
    Route::get('/e-forms/leave-detailed', [LeaveApplication::class, 'fetchDetailedLeave'])->name('eforms.leaves-detailed');

    Route::post('/e-forms/head-approve', [LeaveApplication::class, 'headApproveLeave'])->name('eforms.head-approve-leave');
    Route::post('/e-forms/revoke-leave', [LeaveApplication::class, 'revokeLeave'])->name('eforms.revoke-leave');



    Route::get('/hris/eleave', [LeaveFormController::class, 'index'])->name('hris.leave.eleave');
    Route::post('/hris/submit-leave', [LeaveFormController::class, 'submitLeave']);
    Route::get('/leave-overlapping', [LeaveFormController::class, 'overlapValidation']);
    Route::get('/hris/eleave/balance', [LeaveFormController::class, 'show_balance'])->name('hris.leave.leave-balance');



    Route::get('/hris/view-leave', [ViewLeavesController::class, 'show_leave'])->name('hris.leave.view-leave');
    Route::get('/hris/filter-leave', [ViewLeavesController::class, 'filter_leave'])->name('hris.leave.filter-leave');
    Route::post('/hris/filter-leave', [ViewLeavesController::class, 'filter_leave'])->name('hris.leave.filter-leave');
    Route::get('/hris/view-leave-details', [ViewLeavesController::class, 'view_leave'])->name('hris.leave.view-leave-details');
    Route::post('/hris/update-leave', [ViewLeavesController::class, 'update_leave'])->name('hris.leave.update-leave');
    Route::post('/hris/delete-leave', [ViewLeavesController::class, 'update_delete_leave'])->name('hris.leave.update-delete-leave');
    Route::post('/head-approve', [ViewLeavesController::class, 'head_approve_leave'])->name('hris.leave.head-approve-leave');
    Route::post('/hr-approve', [ViewLeavesController::class, 'hr_approve_leave'])->name('hris.leave.hr-approve-leave');

    Route::post('/hris/yes-button-leave', [ViewLeavesController::class, 'yes_button_leave'])->name('hris.leave.yes-button-leave');

    Route::get('/hris/view-history', [ViewLeavesController::class, 'view_leave_history']);
    Route::get('/hris/view-leave/fetch_data', [ViewLeavesController::class, 'fetch_data']);

    /*======= OVERTIME ======*/
    Route::get('/hris/overtime', [OvertimesController::class, 'index'])->name('hris.overtime');
    Route::post('/hris/overtime', [OvertimesController::class, 'submitOvertime'])->name('submit.overtime');
    Route::get('/hris/view-overtime', [OvertimesController::class, 'viewOvertimes'])->name('hris.view-overtime');
    Route::get('/hris/view-overtime-details', [OvertimesController::class, 'viewOvertimeDetails'])->name('hris.view-overtime-details');
    Route::get('/hris/view-othistory', [OvertimesController::class, 'viewOvertimeHistory']);
    Route::post('/hris/cancel-overtime', [OvertimesController::class, 'cancelOvertime'])->name('cancel.overtime');
    Route::post('/hris/deny-overtime', [OvertimesController::class, 'denyOvertime'])->name('deny.overtime');
    Route::post('/hris/approve-overtime', [OvertimesController::class, 'approveOvertime'])->name('approve.overtime');


    Route::get('/e-forms/overtime-listing', OvertimeRequests::class)->name('eforms.overtime-listing');
    Route::get('/e-forms/overtime-detailed', [OvertimeRequests::class, 'fetchDetailedLeave'])->name('eforms.overtime-detailed');


    /*======= WFH SET-UP (WORK-FROM-HOME) ======*/
    Route::get('/hris/wfhsetup', WorkFromHome::class)->name('hris.wfhsetup');


    /*======= REIMBURSEMENT =======*/
    Route::get('/reimbursement', [ReimbursementController::class, 'index'])->name('reimbursement');
    Route::post('/reimbursement', [ReimbursementController::class, 'submitReimbursement'])->name('submit.reimbursement');

    /*======= PROCESSING - E-LEAVE begin =======*/
    Route::get('/process-eleave', [ProcessController::class, 'show_process'])->name('process.eleave');
    Route::get('/view-processing-leave', [ProcessController::class, 'processLeaveCount']);
    Route::post('/processing-leave', [ProcessController::class, 'processingLeave']);

    /*======= RECORDS MANAGEMENT =======*/
    /* EMPLOYEES */
    // Route::get('/employees', [EmployeesController::class, 'index'])->name('hr.management.employees');
    Route::middleware(['allowOnlySuperAdmin'])->group(function () {
        Route::get('/employees', [EmployeesController::class, 'index'])->name('hr.management.employees');
    });

    Route::get('/getemployees', [EmployeesController::class, 'getEmployeeInfo']);
    Route::post('/updateemployees', [EmployeesController::class, 'updateEmployee']);
    Route::get('/verify-duplicate', [EmployeesController::class, 'verifyDuplicate'])->name('verify.duplicate');


    /* BENEFITS - LEAVE CREDITS */
    Route::get('/employee-benefits', [EmployeesController::class, 'employeeBenefits'])->name('employee-benefits');
    Route::get('/benefits/leave-credits', LeaveCredits::class)->name('benefits.leave.credits');


    /* CLEARANCE */
    Route::get('/clearance-form', [ClearancesController::class, 'index'])->name('clearance.form');

    /* ======= SETUP ======*/
    /* HOLIDAYS */
    Route::get('/holidays', [HRManagementController::class, 'view_holidays'])->name('hr.management.holidays');
    Route::get('/filter-holidays', [HRManagementController::class, 'filter_holidays'])->name('hr.management.filter-holidays');
    Route::post('/save-holidays', [HRManagementController::class, 'save_holidays'])->name('hr.management.save-holidays');
    Route::post('/update-holidays', [HRManagementController::class, 'update_holidays'])->name('hr.management.update-holidays');

    /* DEPARTMENTS */
    Route::get('/departments', [HRManagementController::class, 'view_departments'])->name('hr.management.departments');
    Route::get('/filter-departments', [HRManagementController::class, 'filter_departments'])->name('hr.management.filter-departments');
    Route::post('/save-departments', [HRManagementController::class, 'save_departments'])->name('hr.management.save-departments');
    Route::post('/update-departments', [HRManagementController::class, 'update_departments'])->name('hr.management.update-departments');

    /* OFFICES */
    Route::get('/offices', [OfficesController::class, 'view_offices'])->name('hr.management.offices');
    Route::get('/filter-offices', [OfficesController::class, 'filter_offices'])->name('hr.management.filter-offices');
    Route::post('/save-offices', [OfficesController::class, 'save_offices'])->name('hr.management.save-offices');
    Route::post('/update-offices', [OfficesController::class, 'update_offices'])->name('hr.management.update-offices');
    Route::get('/getoffice', [OfficesController::class, 'geOfficeDetails'])->name('hr.management.getoffice-details');

    /* USER MANAGEMENT / AUTHORIZE VIEWING */
    Route::get('/setup/user-groups', UserGroups::class)->name('setup.usergroups');
    Route::get('/authorize-user-list', AuthorizeView::class)->name('authorize.user.list');
    Route::get('/authorize-user-detail', [AuthorizeView::class, 'fetchDetailedUser'])->name('authorize.user.detail');
    Route::post('/save-authorize-viewing', [AuthorizeView::class, 'saveAssignedViewing']);


    /* MODULE CREATION */
    Route::get('/module-list', ModuleCreation::class)->name('module.list');
    Route::get('/module-creation', [ModuleCreation::class, 'moduleCreation'])->name('module.creation');
    Route::post('/create-module', [ModuleCreation::class, 'createModule'])->name('create.module');


    /* COUNTRIES, PROVINCES, CITIES */
    Route::get('/provinces', [CountriesController::class, 'provinces'])->name('provinces');
    Route::get('/cities', [CountriesController::class, 'cities'])->name('cities');
    Route::get('/barangays', [CountriesController::class, 'barangays'])->name('barangays');
    Route::get('/zipcodes', [CountriesController::class, 'zipcodes'])->name('zipcodes');

    /* MEMO */
    Route::get('/memos', [HRMemoController::class, 'view_memos'])->name('hr.management.memos');
    Route::post('/tmp-preview-memo', [PageController::class, 'tmp_preview_memo'])->name('tmp.file.preview');
    Route::get('/preview-memo', [PageController::class, 'preview_memo'])->name('file.preview');
    Route::get('/view-memo', [PageController::class, 'view_memo'])->name('view.memo');
    Route::get('/remove-tmp-memo', [PageController::class, 'remove_tmp_memo'])->name('remove.tmp.file');
    Route::post('/send-memo', [HRMemoController::class, 'send_memo'])->name('send.memo');
    Route::get('/memo-data', [HRMemoController::class, 'memo_data'])->name('memo.data');
    Route::post('/memo-viewed', [HRMemoController::class, 'memo_viewed'])->name('memo.viewed');

    Route::post('ckeditor/upload', [CKEditorController::class, 'upload'])->name('ckeditor.image-upload');

    /*======= PERSONNEL - ACCOUNTING DATA =======*/
    Route::post('/update-accounting-data', [PersonnelAccountingDataController::class, 'updateAccountingData'])->name('update-accounting-data');

    /*======= UTILITIES =======*/
    /* FULL CALENDAR */
    Route::get('/fullcalendar', [FullCalenderController::class, 'index'])->name('calendar');
    Route::post('/fullcalenderAjax', [FullCalenderController::class, 'ajax']);


    /*======= Google Calendar Intergration =======*/
    Route::get('/testCalendar', [TestController::class, 'testCalendar'])->name('test.calendar');
    Route::get('/events/create', [TestController::class, 'createEventForm'])->name('events.create');
    Route::post('/events/store', [TestController::class, 'storeEvent'])->name('events.store');


    /* WEBCAM CAPTURE PHOTO */
    Route::get('webcam', [WebcamController::class, 'index'])->name('webcam');
    Route::get('webcam-capture', [WebcamController::class, 'index'])->name('webcam-capture');
    Route::post('webcam', [WebcamController::class, 'store'])->name('webcam.capture');

    /* QR CODE */
    Route::get('/qr-code', [QRCodeController::class, 'index'])->name('qr-code');
    Route::get('/download-multiple-qrcodes', [QRCodeController::class, 'downloadMultipleQRCodes']);

    /*======= REPORTS =======*/
    Route::get('/generate-pdf', [PDFController::class, 'generatePDF']);
    Route::get('/view-pdf', [PDFController::class, 'viewPDF']);
    Route::get('/generate-docx', [HomeController::class, 'generateDocx']);
    Route::get('/document/convert-word-to-pdf', [PDFController::class, 'convertWordToPDF'])->name('document.wordtopdf');

    Route::get('file-upload', [FileController::class, 'index']);
    Route::post('file-upload', [FileController::class, 'store'])->name('file.store');

    Route::get('/uploadFile', [PageController::class, 'index']);
    Route::post('/uploadFile', [PageController::class, 'uploadFile'])->name('uploadFile');

    Route::get('/convert-image-to-pdf', [PDFController::class, 'convertImagesToPDF']);

    /* Route for Personal data sheet */
    Route::get('/user/profile/pds/{emp_id}', [PersonalDataSheetController::class, 'personaldatasheet']);
    /* Route for Leave Form */
    Route::get('/hris/view-leave/form-leave/{leave_id}', [LeaveFormController::class, 'leaveform']);

    /* Export to Excel */
    Route::get('/leaves-excel', [ViewLeavesController::class, 'leavesExcel'])->name('leaves.excel');
    Route::get('/overtimes-excel', [OvertimesController::class, 'overtimesExcel'])->name('overtimes.excel');
    Route::get('/timelogs-excel', [EmployeesController::class, 'timeLogsExcel'])->name('timelogs.excel');
    Route::get('/export-timelogs-xls', [Timelogs::class, 'timeLogsExcel'])->name('export.timelogs.excel');

    Route::get('/ot-timelogs-excel', [OvertimesController::class, 'otTimeLogsExcel'])->name('ot.timelogs.excel');

    /* ===== MAIL ======*/
    Route::get('/send-mail', [PageController::class, 'send_mail']);

    /* TESTING ONLY */
    /*Route::middleware(['allowOnlyAdmin',config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')])->group(function() {
        Route::get('/test', [TestController::class,'test_view']);
    });*/

    Route::get('/tcpdf', [HomeController::class, 'createPDF'])->name('createPDF');

    Route::get('/counter', [PusherNotificationController::class, 'view_push'])->name('view.push');

    Route::get('/sender', [PusherNotificationController::class, 'sender_push'])->name('sender.push');
    Route::post('/sender', [PusherNotificationController::class, 'send_push'])->name('send.push');

    Route::get('/pusher', [PusherNotificationController::class, 'notification_count'])->name('counts_pusher');

    Route::get('/encrypt', function () {
        return view('test/encrypt');
    });
    Route::get('/decrypt', function () {
        return view('test/decrypt');
    });

    /*======= TIME LOGS =======*/
    Route::get('/timelogs-listing', Timelogs::class)->name('timelogs-listing');
    Route::get('/timelogs-perday', [Timelogs::class, 'timelogsPerday'])->name('timelogs-perday');
    Route::post('/send-timelogs-to-hris', [Timelogs::class, 'sendTimelogsAPIHRIS'])->name('send.timelogs.to.hris');

    # FACE RECOGNITION AND VALIDATION #
    Route::get('/face-registered-listing', FaceRegistration::class)->name('face.registered.listing');
    Route::get('/face-registration', [FaceRegistration::class, 'userFaceRegistration'])->name('face.registration');
    Route::get('/faces/register', [FaceRegistrationController::class, 'index'])->name('faces.create');
    Route::post('/faces/register', [FaceRegistrationController::class, 'store'])->name('faces.store');
    Route::post('/faces/detect', [FaceRegistrationController::class, 'detect'])->name('faces.detect');


    /*======= EMPLOYEES =======*/
    Route::get('/employees-listing', Employees::class)->name('employees-listing');
    Route::get('/employee-detailed', [Employees::class, 'fetchDetailedEmployee']);
    Route::post('/update-employee-info', [Employees::class, 'updateEmployeeInfo']);

    Route::get('/timelogs', [WebcamController::class, 'timeLogs'])->name('timelogs');
    Route::post('/save-timelogs', [WebcamController::class, 'saveTimeLogs'])->name('save.timelogs');
    Route::get('/create-image-path', [WebcamController::class, 'createNewImagePath'])->name('create.image.path');

    Route::get('/timelogslisting', [EmployeesController::class, 'timeLogsListing'])->name('timelogslisting');
    Route::get('/timelogs-detailed', [EmployeesController::class, 'timeLogsDetailed'])->name('timelogs.detailed');



    /*======= SERVER STATUS =====*/
    Route::get('/server-status', ServerStatus::class)->name('server-status');

    // Route::middleware(['allowOnlyAdmin',config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')])->group(
    // function() {
    /* ATTENDANCE MONITORING */
    Route::get('/attendance-monitoring', AttendanceMonitoring::class)->name('attendance-monitoring');
    // });
});


/*=======  EMAIL NOTIFICATION AND API(GOOGLE, HRIS) =======*/
/*======= LEAVE APPLICATION =====*/
Route::post('/e-forms/notify-leave-action', [LeaveApplication::class, 'gCalendarAndMail']);
Route::get('/leave/{action}/{hashId}', [LeaveFormController::class, 'leaveHeadDecide'])->name('leave.decide');
Route::post('/leave-link/head-approve', [LeaveApplication::class, 'linkHeadApproveLeave'])->name('leave-link.head-approve-leave');
Route::post('/leave-link/head-deny', [LeaveApplication::class, 'linkHeadDenyLeave'])->name('leave-link.head-deny-leave');

/*=======  OVERTIME REQUEST =======*/
Route::post('/e-forms/notify-overtime-action', [OvertimesController::class, 'mailOvertimeRequest']);
Route::get('/overtime/{action}/{hashId}', [OvertimesController::class, 'overtimeHeadDecide'])->name('overtime.decide');
Route::post('/overtime-link/head-approve', [OvertimesController::class, 'linkHeadApproveOvertime'])->name('overtime-link.head-approve');
Route::post('/overtime-link/head-deny', [OvertimesController::class, 'linkHeadDenyOvertime'])->name('overtime-link.head-deny');

/*=======  HRIS API =======*/
Route::post('/send-leave-to-hris', [LeaveApplication::class, 'sendToHRIS'])->name('send.to.hris');
Route::post('/send-allleave-to-hris', [LeaveApplication::class, 'sendAllToHRIS'])->name('sendall.to.hris');


Route::post('/send-overtime-to-hris', [OvertimesController::class, 'sendOvertimeToHRIS'])->name('send.overtime.to.hris');


/*======= CRON / SCHEDULER =====*/
Route::get('/cron-autocompute-leavecredits', [CronController::class, 'cronAutoComputeLeaveCredits'])->name('cron.autocompute.leavecredits');
Route::get('/cron-pending-request-notification', [CronController::class, 'cronAutoPendingRequestNotification'])->name('cron.pending.request.notification');


/* test only */
Route::get('/test', [TestController::class, 'test_view']);
// Route::get('/dump-leaves-to-google-calendar', [TestController::class,'dumpLeavesToGoogleCalendar']);
Route::get('/sample-sidebar-navigation', [TestController::class, 'sampleSidebar']);
