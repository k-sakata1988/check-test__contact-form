<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [ContactController::class,'index']);
Route::post('/contacts/confirm', [ContactController::class, 'confirm']);
Route::post('/contacts', [ContactController::class, 'store']);
Route::get('/contacts/edit', [ContactController::class, 'edit']);
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{id}', [AdminController::class, 'show'])->name('contacts.show');
    Route::delete('/contacts/{id}', [AdminController::class, 'destroy'])->name('contacts.destroy');
    Route::get('/export', [AdminController::class, 'export'])->name('contacts.export');
    Route::middleware('auth')->group(function(){
        Route::get('/',[AdminContactController::class,'index']);
    });
});