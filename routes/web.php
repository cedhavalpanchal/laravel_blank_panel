<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ChangePasswordController;
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
    return redirect('login');
});

Auth::routes();

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.forgot');

Route::post('send-password-link', [ResetPasswordController::class, 'store'])->name('password-reset-link');
Route::post('password-update', [ResetPasswordController::class, 'updatePassword'])->name('password.update');
Route::get('reset-password-form/{token}', [ResetPasswordController::class, 'showResetPasswordForm'])->name('reset-password-form');

Route::group(['middleware' => ['auth']], function () {

    Route::get("dashboard", [HomeController::class,'index'])->name("dashboard");
    // Add your profile management routes here
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::get('/change-password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('change-password');
    Route::post('/change-password', [ChangePasswordController::class, 'changePassword'])->name('change-password.post');

    // Define your route for creating a supplier here
    // Route::get('/create-supplier', [SupplierController::class, 'create'])->name('supplier.create');
    // Route::post('/store-supplier', [SupplierController::class, 'store'])->name('supplier.store');
    // Route::get('/suppliers', [SupplierController::class, 'showSuppliers'])->name('suppliers.index');
    // Route::post('/supplier/update-status', [SupplierController::class, 'updateStatus'])->name('supplier.updateStatus');
    // Route::get('/supplier/edit/{id}', [SupplierController::class, 'editSupplier'])->name('supplier.edit');
    // Route::put('/supplier/update/{id}', [SupplierController::class, 'updateSupplier'])->name('supplier.update');
    // Route::delete('suppliers/{id}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
    // Route::post('/suppliers/bulk-delete', [SupplierController::class, 'bulkDelete'])->name('suppliers.bulkDelete');
    // Route::post('/suppliers/resend-password-link/{id}', [SupplierController::class, 'resendPasswordLink'])->name('suppliers.resendPasswordLink');

    // Define your route for creating a category here
    Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/create-category', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/store-category', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::post('/category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.delete');
    Route::post('/category/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('category.bulkDelete');
});
