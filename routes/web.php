<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StudentController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin/', 'middleware' => 'auth'], function(){
    Route::get('dashboard', [DashboardController::class, 'index']);
     //Student route
     Route::get('student', [StudentController::class, 'index']);
     Route::post('student-store', [StudentController::class, 'store']);
     Route::put('student-update/{id}', [StudentController::class, 'update']);
     Route::delete('student-delete/{id}', [StudentController::class, 'destroy']);

});
