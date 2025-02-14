<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FIleController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourtController;
use App\Http\Controllers\JudgeController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\PurposeController;
use App\Http\Controllers\CasetypeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoggedActivityController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;


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
//NO middleware
Route::get('/firstAdmin/form',[UserController::class, 'createAdmin'])->name("first.admin");
Route::post('/firstAdmin', [UserController::class,'store'])->name('store.first.admin');
Route::post('/logIn',[AuthController::class,'login'])->name('index.auth');
Route::get('/back/{url}',[SystemController::class,'back'])->name('redirect.back');
Route::get('/forgot/password',[AuthController::class,'forgotPassword'])->name('forgot.password.form');
Route::post('/forgot/password/email',[AuthController::class,'forgotPasswordEmail'])->name('forgot');
Route::get('/email/sent',function(){ return view('user.sent-reset-link');})->name('reset.password.email.sent');
Route::get('/reset/password/{token}',[AuthController::class,'resetPasswordForm'])->name('reset.password.form');
route::post('/reset/new/password/{token}', [AuthController::class,'resetPassword'])->name('reset.password');

Route::middleware(['verified'])->group(function(){
    Route::get('/email/verify',[AuthController::class,'verifyEmailForm'])->name('verify.email.form');
    Route::post('/email/verifyEmail',[AuthController::class,'verifyOTP'])->name('verify.otp');
    Route::get('/otp/resend',[AuthController::class,'resendOTP'])->name('resend.otp');
});

//Auth middleware group
Route::middleware(['user.auth','verified'])->group(function(){
    Route::get('/', function(){return view('index');})->name('index');
    Route::get('/user', [DashboardController::class,'userDash'])->name('user');
    Route::get('/logOut',[AuthController::class,'logout'])->name('logout');
});

//Admin routes
Route::middleware([ 'user.auth','admin','verified'])->group(function () {
    Route::get('/admin', [DashboardController::class,'adminDash'])->name('admin');
    Route::get('/user/list', [UserController::class,'index'])->name('user.list');
    Route::get('/user/new', [UserController::class,'create'])->name('create.user.form');
    Route::get('/user/{id}', [UserController::class,'edit'])->name('edit.user.form');
    Route::put('/user/edit/{id}', [UserController::class,'editUser'])->name('edit.user');
    Route::post('/user/add/new', [UserController::class,'store'])->name('store.new.user');
    Route::delete('/user/delete/{id}',[UserController::class,'destroy'])->name('destroy.user');
});

// files management ....
Route::middleware(['user.auth','verified'])->group(function (){
    Route::get('/files/listFiles', [FIleController::class,'index'])->name('list.files');
    Route::get('/files/searchFile', [FIleController::class,'fileSearch'])->name('search.file');
    Route::get('/files/searchFiles/{id}', [FIleController::class,'search'])->name('get.file');
    Route::get('/files/newFile', [FIleController::class,'create'])->name('create.file.form');
    Route::post('/files/addNewFile', [FIleController::class,'store'])->name('store.new.file');
    Route::get('/file/info/{id}',[FIleController::class,'info'])->name('file.info');

});

//File transactions
Route::middleware(['user.auth','verified'])->group(function (){
    Route::get('/files/loanFile/{id}', [TransactionController::class,'loan'])->name('loan.file');
    Route::post('/files/loan/{id}', [TransactionController::class,'storeLoan'])->name('store.loan.file');
    Route::get('/files/return',[TransactionController::class,'returnFile'])->name('return.file');
    Route::get('/files/return/{id}',[TransactionController::class,'returnFile'])->name('return.file.info');
    route::get('/files/storeReturn/{id}',[TransactionController::class,'storeReturn'])->name('store.return.file');
});

// System
//system config 
Route::middleware(['user.auth','verified'])->group(function (){
    //case types
    Route::get('/config/caseTypes',[CasetypeController::class,'index'])->name('config.caseType');
    Route::post('/config/caseTypes/newCaseType',[CasetypeController::class,'store'])->name('store.new.caseType');
    Route::delete('/config/caseType/{id}',[CasetypeController::class,'destroy'])->name('destroy.caseType');
    Route::get('/config/edit/caseType/{id}', [CasetypeController::class, 'edit'])->name('update.caseType.form');
    Route::put('/config/update/caseType/{id}', [CasetypeController::class, 'update'])->name('update.caseType');
    //courts
    Route::get('/config/court',[CourtController::class,'index'])->name('config.court');
    Route::post('/config/courts/newCourt',[CourtController::class,'store'])->name('store.new.court');
    Route::delete('/config/court/{id}',[CourtController::class,'destroy'])->name('destroy.court');
    Route::get('/config/edit/court/{id}', [CourtController::class, 'edit'])->name('update.court.form');
    Route::put('/config/update/court/{id}', [CourtController::class, 'update'])->name('update.court');
    //judges
    Route::get('/config/judge',[JudgeController::class,'index'])->name('config.judge');
    Route::post('/config/judges/newJudge',[JudgeController::class,'store'])->name('store.new.judge');   
    Route::delete('/config/destroy/judge/{id}',[JudgeController::class,'destroy'])->name('destroy.judge');
    Route::get('/config/edit/judge/{id}',[JudgeController::class,'edit'])->name('update.judge.form');
    Route::put('/config/update/judge/{id}',[JudgeController::class,'update'])->name('update.judge');
    //purpose
    Route::get('/config/purpose',[PurposeController::class,'index'])->name('config.purpose');
    Route::post('/config/purpose/newpurpose',[PurposeController::class,'store'])->name('store.new.purpose');  
    Route::delete('/config/destroy/purpose/{id}',[PurposeController::class,'destroy'])->name('destroy.purpose');
    Route::get('/config/edit/purpose/{id}',[PurposeController::class,'edit'])->name('update.purpose.form');
    Route::put('/config/update/purpose/{id}',[PurposeController::class,'update'])->name('update.purpose');
    
});

// Departments
Route::middleware(['user.auth','admin','verified'])->group(function(){
    Route::get('/system/departments',[SystemController::class,'department'])->name('new.department');
    Route::post('/system/new/department',[SystemController::class,'storeDepartment'])->name('store.new.department');
    Route::get('/system/edit/department/{id}',[SystemController::class,'editDepartment'])->name('edit.department.form');
    Route::get('/system/delete/{id}',[SystemController::class,'destroyDepartment'])->name('destroy.department');
    Route::put('/system/edit/{id}',[SystemController::class,'updateDepartment'])->name('edit.department');
});



//User Profile

Route::middleware(['user.auth','verified'])->group(function () {
    Route::get('/profile', [UserController::class,'profile'])->name('user.profile');
    Route::put('/profile/update',[UserController::class,'profileUpdate'])->name('update.profile');
});

// Logged activities

Route::middleware(['user.auth','admin','verified'])->group(function (){
    Route::get('/activities', [LoggedActivityController::class,'index'])->name('logged.activities');
    Route::post('/activities/delete',[LoggedActivityController::class,'deleteSelectedActivities'])->name('delete.selected.activities');
});

// Reports

Route::middleware(['user.auth','verified'])->group( function(){
    Route::get('/report/disposalFiles',[ReportController::class, 'disposalFiles'])->name('disposal.files');
    Route::get('/report/mature/pdf',[ReportController::class, 'downloadMatureFiles'])->name('mature.download.pdf');
    Route::get('/report/onLoan/pdf',[ReportController::class, 'downloadOnLoanPDF'])->name('onloan.dolwnload.pdf');

});


/**
 * Client 
 */

 Route::middleware((['user.auth','verified']))->group( function(){
    Route::get('/client/new',[ClientController::class,'index'])->name('new.client');
    Route::post('/client/register',[ClientController::class,'store'])->name('store.new.client');
 });

/**
 * Messaging
 */

 Route::get('/message',[MessageController::class,'index'])->name('message.new');
 Route::post('/message/send',[MessageController::class,'store'])->name('send.message');
 Route::post('/message/recived',[MessageController::class,'recived'])->name('sms.recived');
 Route::post('/message/clear',[MessageController::class,'clear'])->name('message.clear');