<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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

// Route::get('/', function () {
//     return view('login');
// });

Route::controller(AuthController::class)->group(function(){
    Route::post('/process', [AuthController::class, 'process'])->name('login.process');
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::get('/register', [AuthController::class, 'registration'])->name('register');
    Route::post('/register/save', [AuthController::class, 'processRegistration'])->name('save.register');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::group(['middleware' => ['auth']], function() {
    Route::group(['middleware' => ['authLogin:admin']], function(){
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::post('/dashboard/pasien/process', [AdminController::class, 'storePasien'])->name('save.pasien');
        Route::get('/dashboard/pasien/edit', [AdminController::class, 'editPasien'])->name('edit.pasien');
        Route::put('/dashboard/pasien/update', [AdminController::class, 'updatePasien'])->name('update.pasien');
        Route::delete('/dashboard/pasien/delete', [AdminController::class, 'destroyPasien'])->name('delete.pasien');
        Route::put('/dashboard/pasien/status', [AdminController::class, 'statusPasien'])->name('status.pasien');

        // CRUD Medicine
        Route::get('/dashboard/medicine', [AdminController::class, 'medicine'])->name('medicine');
        Route::post('/dashboard/medicine/process', [AdminController::class, 'storeMedicine'])->name('save.medicine');
        Route::get('/dashboard/medicine/edit', [AdminController::class, 'editMedicine'])->name('edit.medicine');
        Route::put('/dashboard/medicine/update', [AdminController::class, 'updateMedicine'])->name('update.medicine');
        Route::delete('/dashboard/medicine/delete', [AdminController::class, 'destroyMedicine'])->name('delete.medicine');

        // CRUD Tindakan
        Route::get('/dashboard/action', [AdminController::class, 'action'])->name('action');
        Route::post('/dashboard/action/process', [AdminController::class, 'storeAction'])->name('save.action');
        Route::get('/dashboard/action/edit', [AdminController::class, 'editAction'])->name('edit.action');
        Route::put('/dashboard/action/update', [AdminController::class, 'updateAction'])->name('update.action');
        Route::delete('/dashboard/action/delete', [AdminController::class, 'destroyAction'])->name('delete.action');


        // CRUD Employee
        Route::get('/dashboard/employee', [AdminController::class, 'employee'])->name('employee');
        Route::post('/dashboard/employee/process', [AdminController::class, 'storeEmployee'])->name('save.employee');
        Route::get('/dashboard/employee/edit', [AdminController::class, 'editEmployee'])->name('edit.employee');
        Route::put('/dashboard/employee/update', [AdminController::class, 'updateEmployee'])->name('update.employee');
        Route::delete('/dashboard/employee/delete', [AdminController::class, 'destroyEmployee'])->name('delete.employee');


        // CRUD Employee
        Route::get('/dashboard/region', [AdminController::class, 'region'])->name('region');
        Route::post('/dashboard/region/process', [AdminController::class, 'storeRegion'])->name('save.region');
        Route::get('/dashboard/region/edit', [AdminController::class, 'editRegion'])->name('edit.region');
        Route::put('/dashboard/region/update', [AdminController::class, 'updateRegion'])->name('update.region');
        Route::delete('/dashboard/region/delete', [AdminController::class, 'destroyRegion'])->name('delete.region');
    });
});

Route::group(['middleware' => ['auth']], function() {
    Route::group(['middleware' => ['authLogin:user']], function(){
        Route::get('/home', [UserController::class, 'index'])->name('home');
    });
});