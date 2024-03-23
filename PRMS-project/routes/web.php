<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FIleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourtController;
use App\Http\Controllers\JudgeController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\PurposeController;
use App\Http\Controllers\CasetypeController;
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
Route::post('/firstAdmin', [UserController::class,'storeAdmin'])->name('store.first.admin');
Route::post('/logIn',[AuthController::class,'login'])->name('index.auth');

//Auth middleware group
Route::middleware(['user.auth'])->group(function(){
    Route::get('/', function(){return view('index');})->name('index');
    Route::get('/user', function(){ return view('user/home'); })->name('user');
    Route::get('/logOut',[AuthController::class,'logout'])->name('logout');
});

//Admin routes
Route::middleware([ 'user.auth','admin'])->group(function () {
    Route::get('/admin', function(){return view('admin.home');})->name('admin');
    Route::get('/newUser', [UserController::class,'create'])->name('create.user.form');
    Route::get('/user/{id}', [UserController::class,'edit'])->name('edit.user.form');
    Route::put('/user/{id}/edit', [UserController::class,'update'])->name('edit.user');
    Route::get('/listUser', [UserController::class,'index'])->name('index.users');
    Route::post('/addNewUser', [UserController::class,'store'])->name('store.new.user');
    Route::delete('/deleteUser/{id}',[UserController::class,'destroy'])->name('destroy.user');
});

// files management ....
Route::middleware(['user.auth'])->group(function (){
    Route::get('/files/listFIles', [FIleController::class,'index'])->name('list.files');
    Route::post('/files/searchFile', [FIleController::class,'search'])->name('search.file');
    Route::get('/files/newFile', [FIleController::class,'create'])->name('create.file.form');
    Route::post('/files/addNewFile', [FIleController::class,'store'])->name('store.new.file');
    Route::get('/file/info/{id}',[FIleController::class,'info'])->name('file.info');
});

//File transactions
Route::middleware(['user.auth'])->group(function (){
    Route::get('/files/loanFile/{id}', [TransactionController::class,'loan'])->name('loan.file');
    Route::post('/files/loan/{id}', [TransactionController::class,'storeLoan'])->name('store.loan.file');
    Route::get('/files/return',[TransactionController::class,'returnFile'])->name('return.file');
    Route::get('/files/return/{id}',[TransactionController::class,'returnFile'])->name('return.file.info');
    route::get('/files/storeReturn/{id}',[TransactionController::class,'storeReturn'])->name('store.return.file');
});

// System
//system config 
Route::middleware(['user.auth'])->group(function (){
    //case types
    Route::get('/config/caseTypes',[CasetypeController::class,'index'])->name('config.caseType');
    Route::post('/config/caseTypes/newCaseType',[CasetypeController::class,'store'])->name('store.new.caseType');
    //courts
    Route::get('/config/court',[CourtController::class,'index'])->name('config.court');
    Route::post('/config/courts/newCourt',[CourtController::class,'store'])->name('store.new.court');
    //judges
    Route::get('/config/judge',[JudgeController::class,'index'])->name('config.judge');
    Route::post('/config/judges/newJudge',[JudgeController::class,'store'])->name('store.new.judge');   
    //judges
    Route::get('/config/purpose',[PurposeController::class,'index'])->name('config.purpose');
    Route::post('/config/purpose/newpurpose',[PurposeController::class,'store'])->name('store.new.purpose');  
    
});

// Departments
Route::middleware(['user.auth','admin'])->group(function(){
    Route::get('/system/departments',[SystemController::class,'department'])->name('new.department');
    Route::post('/system/new/department',[SystemController::class,'storeDepartment'])->name('store.new.department');
    Route::get('/system/edit/department/{id}',[SystemController::class,'editDepartment'])->name('edit.department.form');
    Route::get('/system/delete/{id}',[SystemController::class,'destroyDepartment'])->name('destroy.department');
    Route::put('/system/edit/{id}',[SystemController::class,'updateDepartment'])->name('edit.department');
});

Route::get('/back/{url}',[SystemController::class,'back'])->name('redirect.back');