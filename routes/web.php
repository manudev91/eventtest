<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DashboardController;
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

Route::view('/', 'welcome')->name('welcome');

Route::middleware('auth', 'verified')->group(function () {
	Route::get('dashboard', [DashboardController::class,'index'])->name('dashboard');
	Route::view('profile', 'profile')->name('profile');
	Route::get('users',[UserController::class, 'index'])->name('users.index');
	Route::get('events',[EventController::class, 'index'])->name('event.index');
	Route::get('events/create',[EventController::class, 'create'])->name('event.create');
	Route::post('events/store',[EventController::class, 'store'])->name('event.store');
	Route::get('events/edit/{id}',[EventController::class, 'edit'])->name('event.edit');
	Route::post('events/update',[EventController::class, 'update'])->name('event.update');
	Route::delete('events/delete/{id}',[EventController::class, 'destroy'])->name('event.delete');
	Route::post('events/joinevent',[EventController::class, 'joinEvent'])->name('event.joinevent');
	Route::get('userevents',[UserController::class, 'userEvents'])->name('userevents');

	Route::get('events/notify/{enventId}', [EventController::class, 'notifyUser'])->name('notifyUser');
	

});


