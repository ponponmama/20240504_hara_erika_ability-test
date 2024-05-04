<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExportController;


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

Route::get('/register', [AuthController::class,'index']);
Route::get('/login', [AuthController::class,'login'])->name('login');

Route::middleware(['auth'])->group(function () {
Route::get('/admin',[AdminController::class,'index'])->name('admin.index');
Route::get('/admin/search', [AdminController::class, 'search'])->name('admin.search');
Route::get('/admin/reset_search', [AdminController::class, 'resetSearch'])->name('admin.reset_search');
Route::get('/admin/contacts/export_csv', [AdminController::class, 'exportCsv'])->name('admin.contacts.export_csv');

Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');
Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
});

Route::get('/', [ContactController::class,'index'])->name('contacts.index');
Route::post('/contacts/edit', [ContactController::class,'edit'])->name('contacts.edit');
Route::post('/contacts/submit', [ContactController::class,'submit'])->name('contacts.submit');
Route::post('/contacts/confirm', [ContactController::class,'confirm'])->name('contacts.confirm');
Route::get('thanks',[ContactController::class,'thanks'])->name('thanks');