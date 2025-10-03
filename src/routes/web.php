<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

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
// Route::get('/login',[AuthController::class,'index']);
Route::middleware('auth')->group(function(){
    Route::get('/login', [AuthController::class,'index']);
});
Route::get('/register',[AuthController::class,'register']);
Route::prefix('admin')->name('admin.')->group(function() {
    Route::get('/', [AdminController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/export', [AdminController::class, 'export'])->name('contacts.export'); // ←これが必須
    Route::get('/contacts/{id}', [AdminController::class, 'show'])->name('contacts.show');
    Route::delete('/contacts/{id}', [AdminController::class, 'destroy'])->name('contacts.destroy');
});