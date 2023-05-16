<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaveFormController;
use App\Http\Controllers\ViewLeavesController;
use App\Http\Controllers\CalenderController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ProcessController;

use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\HRManagementController;
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

use App\Http\Controllers\PersonalDataSheetController;


use App\Http\Controllers\PersonnelAccountingDataController;

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
    if ( Auth::check() )
    {
        if (Auth::user()->email_verified_at != NULL) {
            return view('/dashboard');
        } else {
            // return view('/auth/login');
            return redirect('/login');
        }
    } else{
        // return view('/auth/login');
        return redirect('/login');
	}
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::get('/welcome', function () {
    if ( Auth::check() )
    {
        if (Auth::user()->email_verified_at != NULL) {
            return view('/welcome');
        } else {
            return view('/auth/login');
        }
    } else{
            return view('/auth/login');
    }
});


/*======= E-LEAVE APPLICATION ======*/
Route::get('/hris/eleave', [LeaveFormController::class, 'index'])->name('hris.leave.eleave');
Route::post('/hris/eleave', [LeaveFormController::class, 'submit_leave']);

Route::get('/hris/eleave/balance', [LeaveFormController::class, 'show_balance'])->name('hris.leave.leave-balance');

Route::get('/hris/view-leave', [ViewLeavesController::class, 'show_leave'])->name('hris.leave.view-leave');
Route::get('/hris/filter-leave', [ViewLeavesController::class, 'filter_leave'])->name('hris.leave.filter-leave');
Route::post('/hris/filter-leave', [ViewLeavesController::class, 'filter_leave'])->name('hris.leave.filter-leave');
Route::get('/hris/view-leave-details', [ViewLeavesController::class, 'view_leave'])->name('hris.leave.view-leave-details');
Route::post('/hris/update-leave', [ViewLeavesController::class, 'update_leave'])->name('hris.leave.update-leave');
Route::post('/hris/delete-leave', [ViewLeavesController::class, 'update_delete_leave'])->name('hris.leave.update-delete-leave');
Route::post('/head-approve', [ViewLeavesController::class, 'head_approve_leave'])->name('hris.leave.head-approve-leave');
Route::post('/hr-approve', [ViewLeavesController::class, 'hr_approve_leave'])->name('hris.leave.hr-approve-leave');

// Route::post('/hris/deny-leave', [ViewLeavesController::class, 'deny_leave'])->name('hris.leave.deny-leave');
Route::post('/hris/yes-button-leave', [ViewLeavesController::class, 'yes_button_leave'])->name('hris.leave.yes-button-leave');

Route::get('/hris/view-history',[ViewLeavesController::class,'view_leave_history']);

Route::get('/hris/view-leave/fetch_data', [ViewLeavesController::class, 'fetch_data']);
// Route::post('/hris/viewleave', [LeaveFormController::class, 'update_leave']);




/*======= PROCESSING - E-LEAVE begin =======*/
Route::get('/process-eleave', [ProcessController::class,'show_process'])->name('process.eleave');
Route::get('/view-processing-leave', [ProcessController::class,'process_leave_count']);
Route::post('/processing-leave', [ProcessController::class,'processing_leave']);


/*======= HR MANAGMENT =======*/
/* EMPLOYEES */
Route::get('/employees', [EmployeesController::class, 'index'])->name('hr.management.employees');
Route::get('/getemployees',[EmployeesController::class,'getEmployeeInfo']);
Route::post('/updateemployees',[EmployeesController::class,'updateEmployee']);


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
Route::get('/getoffice',[OfficesController::class,'geOfficeDetails'])->name('hr.management.getoffice-details');

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
Route::post('/send-memo',[HRMemoController::class, 'send_memo'])->name('send.memo');
Route::get('/memo-data', [HRMemoController::class, 'memo_data'])->name('memo.data');
Route::post('/memo-viewed', [HRMemoController::class, 'memo_viewed'])->name('memo.viewed');

Route::post('ckeditor/upload', [CKEditorController::class, 'upload'])->name('ckeditor.image-upload');


/*======= PERSONNEL - ACCOUNTING DATA =======*/

Route::post('/update-accounting-data',[PersonnelAccountingDataController::class, 'updateAccountingData'])->name('update-accounting-data');







/*======= UTILITIES =======*/
/* FULL CALENDAR */
Route::get('/fullcalender', [FullCalenderController::class, 'index'])->name('calendar');
Route::post('/fullcalenderAjax', [FullCalenderController::class, 'ajax']);
/*Route::get('/leave-calendar', function () {
    return view('/utilities/calendar');
})->name('calendar');*/

/*Route::get('/calendar-event', [CalenderController::class, 'index']);
Route::post('/calendar-crud-ajax', [CalenderController::class, 'calendarEvents']);*/

/* WEBCAM CAPTURE PHOTO */
Route::get('webcam', [WebcamController::class, 'index'])->name('webcam');
Route::get('webcam-capture', [WebcamController::class, 'index'])->name('webcam-capture');
Route::post('webcam', [WebcamController::class, 'store'])->name('webcam.capture');



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
Route::get('/user/profile/pds/{emp_id}', [PersonalDataSheetController::class,'personaldatasheet']);
/* Route for Leave Form */
Route::get('/hris/view-leave/form-leave/{leave_id}', [LeaveFormController::class,'leaveform']);


/* ===== MAIL ======*/
Route::get('/send-mail', [PageController::class, 'send_mail']);


/* TESTING ONLY */
Route::get('/test', [TestController::class,'test_view']);
// Route::get('/hris/{var1}/{var2}', function($var1,$var2) {return $var1."-----------".$var2;});
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
