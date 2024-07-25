<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
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


require __DIR__ . '/auth.php';
    