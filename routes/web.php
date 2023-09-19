<?php

use App\Http\Controllers\OfficeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::resource('products', ProductController::class)->middleware(['auth', 'role:admin']);
Route::resource('offices', OfficeController::class)->middleware(['auth', 'role:admin']);
Route::resource('orders', OrderController::class)->middleware(['auth']);
Route::get('/orders/{status?}', [OrderController::class, 'getOrdersByStatus'])->name('getOrdersByStatus')->middleware(['auth', 'role:admin']);
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create')->middleware(['auth']);
Route::get('/orders/get-new-orders', [OrderController::class, 'getNewOrders'])->name('orders.get-new-orders')->middleware(['auth', 'role:admin']);;
Route::get('/fetch-new-orders', [OrderController::class, 'fetchNewOrders'])->name('orders.fetch-new')->middleware(['auth', 'role:admin']);;
Route::get('/generate-report', [ReportController::class, 'generateReport'])->name('generate.report')->middleware(['auth', 'role:admin']);;
Route::post('/orders-update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status')->middleware(['auth']);;

Route::middleware(['auth', 'role:admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::resource('/roles', RoleController::class);
    Route::post('/roles/{role}/permissions', [RoleController::class, 'givePermission'])->name('roles.permissions');
    Route::delete('/roles/{role}/permissions/{permission}', [RoleController::class, 'revokePermission'])->name('roles.permissions.revoke');
    Route::resource('/permissions', PermissionController::class);
    Route::post('/permissions/{permission}/roles', [PermissionController::class, 'assignRole'])->name('permissions.roles');
    Route::delete('/permissions/{permission}/roles/{role}', [PermissionController::class, 'removeRole'])->name('permissions.roles.remove');
    Route::resource('/users', UserController::class);
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/roles', [UserController::class, 'assignRole'])->name('users.roles');
    Route::delete('/users/{user}/roles/{role}', [UserController::class, 'removeRole'])->name('users.roles.remove');
    Route::post('/users/{user}/permissions', [UserController::class, 'givePermission'])->name('users.permissions');
    Route::delete('/users/{user}/permissions/{permission}', [UserController::class, 'revokePermission'])->name('users.permissions.revoke');
});
