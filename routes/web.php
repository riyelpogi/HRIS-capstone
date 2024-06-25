<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HrController;
use App\Http\Controllers\HrOfficerController;
use App\Livewire\Users\Employee\Trainings;
use App\Models\Interviewee;
use App\Models\jobApplicants;
use App\Models\Jobs;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/phpinfo', function() {
    phpinfo();
});

Route::get('/', function () {

    return redirect(route('applicant.dashboard'));
});

Route::get('redirects', function(){
    if(auth()->user()->role == 2){
        return view('users.hr.dashboard');
    }else if(auth()->user()->role == 1){
        return view('users.employee.dashboard');
    }else if(auth()->user()->role == 0){
        return view('users.applicant.dashboard');
    }
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'is.Employee',
    'is.Deployed',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('users.employee.dashboard');
    })->name('dashboard');
    Route::controller(EmployeeController::class)->group(function() {
        Route::get('/user/employee/dashboard', 'EmployeeDashboard')->name('employee.dashboard');
        Route::get('/user/employee/profile/{cid?}/{content?}', 'showProfile')->name('employee.profile');
        Route::get('/user/employee/trainings/{id?}/{content?}', 'Training')->name('employee.training');
        Route::get('/user/employee/schedule/{id?}/{content?}/{contentofcontent?}', 'Schedule')->name('employee.schedule');
        Route::get('/user/employee/daily/time/record/{id?}/{content?}', 'daily_time_record')->name('employee.daily.time.record');
        Route::get('/user/employee/performance/{id?}/{content?}/{month?}', 'performance')->name('employee.performance');
        Route::get('/user/employee/eventsandnews/{id?}/{content?}', 'eventsandnews')->name('employee.eventsandnews');
        Route::get('/user/employee/benefits/{id?}/{content?}', 'benefits')->name('employee.benefits');
        Route::get('/user/download/certificate/{id}', 'downloadCertificate')->name('user.download.certificate');
    });
});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'is.Employee'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('users.employee.dashboard');
    })->name('dashboard');
    Route::controller(EmployeeController::class)->group(function() {
        Route::get('/user/employee/dashboard', 'EmployeeDashboard')->name('employee.dashboard');
        Route::get('/user/employee/profile/{cid?}/{content?}', 'showProfile')->name('employee.profile');
    });
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'is.Hr'
])->group(function() {
    Route::controller(HrOfficerController::class)->group(function(){
        Route::get('/user/hrofficer/dashboard', 'adminDashboard')->name('admin.dashboard');
        Route::get('/user/hrofficer/profile', 'showProfile')->name('admin.profile');
        Route::get('/user/hrofficer/download/resume/{id}', 'download');
        Route::get('/user/hrofficer/employee/in&out/{content?}', 'EmployeeIndAndOut')->name('admin.employee.inandout');
        Route::get('/user/hrofficer/application/tracker', 'ApplicationTracker')->name('admin.application.tracker');
        // Route::get('/user/hrofficer/users/applicants', 'Applicants')->name('admin.users.applicant');
        Route::get('/user/hrofficer/employees/requests/{content?}', 'EmployeesRequests')->name('admin.employees.requests');
        Route::get('/user/hrofficer/users/employee', 'Employee')->name('admin.users.employee');
        Route::get('/user/hrofficer/employee/trainings/{id?}/{content?}', 'Trainings')->name('admin.trainings');
        Route::get('/user/hrofficer/employee/benefits/{id?}/{content?}', 'Benefits')->name('admin.benefits');
        Route::get('/user/hrofficer/company/announcements', 'Announcements')->name('admin.announcements');
        Route::post('/user/hrofficer/training/learningmaterials/addvideo', 'saveVideo')->name('admin.save.video');
        Route::get('/user/hrofficer/employee/performance', 'EmployeePerformance')->name('admin.employee.performance');
        Route::get('/user/hrofficer/employee/profile/{employeeid}', 'EmployeeProfile')->name('admin.employee.profile');
        Route::get('/download/certificate/{id}', 'downloadCertificate')->name('download.certificate');
    });
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'is.Applicant'
])->group(function() {
    Route::controller(ApplicantController::class)->group(function() {
        Route::get('/user/applicant/profile', 'ApplicantProfile')->name('applicant.profile');
        Route::get('/user/applicant/application/history', 'ApplicationHistory')->name('applicant.application.history');
    });
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'is.Admin'
])->group(function() {
    Route::controller(AdminController::class)->group(function() {
      Route::get('/user/admin/dashboard', 'index')->name('dashboard.admin');
    });
});

Route::get('/user/applicant/dashboard', [ApplicantController::class, 'ApplicantDashboard'])->name('applicant.dashboard');





