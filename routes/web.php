<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\ResponseController;
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
        Route::get          ('/employee/create',  'create')          ->name('employee.create');
        Route::post         ('/employee/store',  'store')            ->name('employee.store');
        Route::get          ('/employee/show',  'show')              ->name('employee.show');
        Route::get          ('/employee/edit/{id}',    'edit')       ->name('employee.edit');
        Route::patch        ('/employee/update/{id}',  'update')     ->name('employee.update');
        Route::delete       ('/employee/destroy/{id}', 'destroy')    ->name('employee.destroy');
    });

//Freelancer
Route::middleware('auth')
    ->controller(FreelancerController::class)
    ->group(function () {
        Route::get      ('/freelancer/create', 'create')       ->name('freelancer.create');
        Route::post     ('/freelancer/store', 'store')         ->name('freelancer.store');
        Route::get      ('/freelancer/show',  'show')          ->name('freelancer.show');
        Route::get      ('/freelancer/edit/{id}', 'edit')      ->name('freelancer.edit');
        Route::patch    ('/freelancer/update/{id}', 'update')  ->name('freelancer.update');
        Route::delete   ('/freelancer/destroy/{id}', 'destroy')->name('freelancer.destroy');
    });

//Vehicle
Route::middleware('auth')
    ->controller(VehicleController::class)
    ->group(function () {
        Route::get      ('/vehicle/create', 'create')       ->name('vehicle.create');
        Route::post     ('/vehicle/store', 'store')         ->name('vehicle.store');
        Route::get      ('/vehicle/show',  'show')          ->name('vehicle.show');
        Route::get      ('/vehicle/edit/{id}', 'edit')      ->name('vehicle.edit');
        Route::patch    ('/vehicle/update/{id}', 'update')  ->name('vehicle.update');
        Route::delete   ('/vehicle/destroy/{id}', 'destroy')->name('vehicle.destroy');
    });

//return_status
route::middleware('auth')
->controller(ResponseController::class)
    ->group(function (){
    route::get('/return/status', 'update')->name('return.status');
    route::patch('/return/accept/{id}', 'accept')->name('return.accept');
    route::patch('/return/recuse/{id}', 'recuse')->name('return.recuse');
});
require __DIR__ . '/auth.php';
