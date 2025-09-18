<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BillAttachmentController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\BillDetailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Invoices_ReportController;
use App\Http\Controllers\Customers_ReportController;
use App\Http\Controllers\HomeController;
use App\Models\BillAttachment;
use App\Models\BillDetail;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard',[HomeController::class,'index']
)->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('/bill', BillController::class);
Route::resource('/section', SectionController::class);
Route::resource('/product', ProductController::class);
Route::get('section/{id}', [BillController::class, 'getProducts']);
Route::get('MarkAsRead_all',[BillController::class, 'MarkAsRead_all'])->name('MarkAsRead_all');
Route::resource('/billdetail', BillDetailController::class);
Route::get('edit_bill/{id}', [BillController::class, 'edit']);
Route::get('/Status_show/{id}',[BillController::class, 'show'])->name('Status_show');
Route::post('/Status_Update/{id}', [BillController::class, 'Status_Update'])->name('Status_Update');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/billDetails/{id}', [BillDetailController::class,'show']);
Route::resource('billAttachments',BillAttachmentController::class );
Route::get('/billpaid',[BillController::class, 'billpaid']);
Route::get('/billunpaid',[BillController::class, 'billunpaid']);
Route::get('/billpartpaid',[BillController::class, 'billpartpaid']);
Route::get('download/{bill_number}/{file_name}', [BillDetailController::class,'get_file']);
Route::get('View_file/{bill_number}/{file_name}',[BillDetailController::class ,'open_file']);

Route::resource('/archive',ArchiveController::class);
Route::get('Print_bill/{id}',[BillController::class,'Print_bill']);
Route::post('delete_file', [BillDetailController::class ,'destroy'])->name('delete_file');

Route::get('/user',[UserController::class,'index'])->name('user.index');
Route::get('/user/create',[UserController::class,'create']);
Route::post('/user/store',[UserController::class,'store'])->name('user.store');
Route::get('/user/edit/{id}',[UserController::class,'edit'])->name('user.edit');
Route::post('/user/update/{id}',[UserController::class,'update'])->name('user.update');
Route::post('/user/destroy',[UserController::class,'destroy'])->name('user.destroy');

Route::get('/role',[RoleController::class,'index'])->name('role.index');
Route::get('/role/create',[RoleController::class,'create'])->name('role.create');
Route::post('/role/store',[RoleController::class,'store'])->name('role.store');
Route::post('/role/update/{id}',[RoleController::class,'update'])->name('roles.update');
Route::post('/role/destroy/{id}',[RoleController::class,'destroy'])->name('roles.destroy');
Route::get('/role/edit/{id}',[RoleController::class,'edit'])->name('roles.edit');
Route::get('/role/show/{id}',[RoleController::class,'show'])->name('roles.show');

Route::get('invoices_report', [Invoices_ReportController::class,'index']);
Route::post('Search_invoices', [Invoices_ReportController::class,'Search_invoices']);

Route::get('customers_report', [Customers_ReportController::class,'index']);
Route::post('Search_customers', [Customers_ReportController::class,'Search_customers']);


require __DIR__.'/auth.php';
Route::get('/{page}', [AdminController::class,'index']);



