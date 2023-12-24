<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
   
// });

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


//simple calendar event subscription app all route--------
Route::get('/events', [EventController::class, 'index'])->name('events');
Route::post('/event/store', [EventController::class, 'store'])->name('event.store');
Route::post('/event/registration', [EventController::class, 'eventRegistration'])->name('event.registration');
Route::get('/admin', [EventController::class, 'admin'])->name('admin');
Route::get('/', [EventController::class, 'user'])->name('user');

require __DIR__.'/auth.php';
