<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\VehicleController;
use App\Models\Freelancer;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Employee
Route::middleware('auth')
    ->controller(EmployeeController::class)
    ->group(function () {
        Route::get      ('/employee/create',  'create')->name('employee.create');
        Route::post      ('/employee/store',  'store')->name('employee.store');
        Route::get      ('/employee/edit',    'edit')->name('employee.edit');
        Route::patch    ('/employee/update',  'update')->name('employee.update');
        Route::delete   ('/employee/destroy','destroy')->name('employee.destroy');
    });

//Freelancer
Route::middleware('auth')
->controller(FreelancerController::class)
->group(function(){
    Route::get('/freelancer/create', 'create')->name('freelancer.create');
    Route::post('/freelancer/store', 'store')->name('freelancer.store');
    Route::get('/freelancer/edit', 'edit')->name('freelancer.edit');
    Route::patch('/freelancer/update', 'update')->name('freelancer.update');
    Route::delete('/freelancer/destroy', 'destroy')->name('freelancer.destroy');
});

//Vehicle
Route::middleware('auth')
->controller(VehicleController::class)
->group(function(){
    Route::get('/vehicle/create', 'create')->name('vehicle.create');
    Route::post('/vehicle/store', 'store')->name('vehicle.store');
    Route::get('/vehicle/edit', 'edit')->name('vehicle.edit');
    Route::patch('/vehicle/update', 'update')->name('vehicle.update');
    Route::delete('/vehicle/destroy', 'destroy')->name('vehicle.destroy');
});

require __DIR__ . '/auth.php';
    