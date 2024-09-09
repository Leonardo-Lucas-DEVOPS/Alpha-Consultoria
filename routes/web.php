<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AffiliateController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth','verified'])->name('dashboard');

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
        Route::patch        ('/employee/accept/{id}', 'accept')      ->name('employee.accept');
        Route::patch        ('/employee/reject/{id}', 'reject')      ->name('employee.reject');
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
        Route::patch    ('/freelancer/accept/{id}', 'accept')  ->name('freelancer.accept');
        Route::patch    ('/freelancer/reject/{id}', 'reject')  ->name('freelancer.reject');
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
        Route::patch    ('/vehicle/accept/{id}', 'accept')  ->name('vehicle.accept');
        Route::patch    ('/vehicle/reject/{id}', 'reject')  ->name('vehicle.reject');
        Route::delete   ('/vehicle/destroy/{id}', 'destroy')->name('vehicle.destroy');
    });

//affiliates
Route::middleware('auth')
->controller(AffiliateController::class)
->group(function () {
    Route::get      ('/affiliate/create', 'create')       ->name('affiliate.create');
    Route::get      ('/affiliate/show',  'show')          ->name('affiliate.show');


    Route::post     ('/affiliate/store', 'store')         ->name('affiliate.store');
    Route::get      ('/affiliate/edit/{id}', 'edit')      ->name('affiliate.edit');
    Route::patch    ('/affiliate/update/{id}', 'update')  ->name('affiliate.update');
    Route::delete   ('/affiliate/destroy/{id}', 'destroy')->name('affiliate.destroy');
});

//admin
Route::middleware('auth')
->controller(AdminController::class)
->group(function () {
    Route::get      ('/admin/create', 'create')       ->name('admin.create');
    Route::post     ('/admin/store', 'store')         ->name('admin.store');
    Route::get      ('/admin/show',  'show')          ->name('admin.show');
    Route::get      ('/admin/edit/{id}', 'edit')      ->name('admin.edit');
    Route::patch    ('/admin/update/{id}', 'update')  ->name('admin.update');
    Route::patch    ('/admin/accept/{id}', 'accept')  ->name('admin.accept');
    Route::patch    ('/admin/reject/{id}', 'reject')  ->name('admin.reject');
    Route::delete   ('/admin/destroy/{id}', 'destroy')->name('admin.destroy');
});

require_once __DIR__ . '/auth.php';
