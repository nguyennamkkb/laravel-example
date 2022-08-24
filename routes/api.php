<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\Api\CodeController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CategoryChildController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\CustomerTypeController;
use App\Http\Controllers\Api\EnterpriseController;
use App\Http\Controllers\Api\SpecificitieController;
use App\Http\Controllers\Api\EmployeeTypeController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\ExportController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\PriceController;
use App\Http\Controllers\Api\InputController;
use App\Http\Controllers\Api\WarehouseController;
use App\Http\Controllers\Api\PaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Route::post('test', [TestController::class, 'Test']);


Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', [LoginController::class, 'logout']);
    Route::get('user', [UserController::class, 'current']);
    Route::patch('settings/profile', [ProfileController::class, 'update']);
    Route::patch('settings/password', [PasswordController::class, 'update']);

    Route::get('codes', [CodeController::class, 'index']); // lay thong toan bo thong tin
    Route::post('codes', [CodeController::class, 'store']); // them moi thong tin
    Route::get('codes/{id}', [CodeController::class, 'show']); // lay thong tin cuar 1 ma
    Route::put('codes/{id}', [CodeController::class, 'update']); // sua thong tin
    Route::delete('codes/{id}', [CodeController::class, 'destroy']); // xoa thong tin
    //user
    Route::get('users', [UserApiController::class, 'index']); // lay thong toan bo thong tin
    Route::post('users', [UserApiController::class, 'store']); // them moi thong tin
    Route::put('users/{id}', [UserApiController::class, 'update']); // sua thong tin
    Route::delete('users/{id}', [UserApiController::class, 'destroy']); // xoa thong tin
    //supplier
    Route::get('suppliers', [SupplierController::class, 'index']); // lay thong toan bo thong tin
    Route::post('suppliers', [SupplierController::class, 'store']); // them moi thong tin
    Route::put('suppliers/{id}', [SupplierController::class, 'update']); // sua thong tin
    Route::delete('suppliers/{id}', [SupplierController::class, 'destroy']); // xoa thong tin
    //Danh muc san pham
    Route::get('category', [CategoryController::class, 'index']); // lay thong toan bo thong tin
    Route::post('category', [CategoryController::class, 'store']); // them moi thong tin
    Route::put('category/{id}', [CategoryController::class, 'update']); // sua thong tin
    Route::delete('category/{id}', [CategoryController::class, 'destroy']); // xoa thong tin
    //Danh muc san pham con
    Route::get('categoryChild', [CategoryChildController::class, 'index']); // lay thong toan bo thong tin
    Route::post('categoryChild', [CategoryChildController::class, 'store']); // them moi thong tin
    Route::put('categoryChild/{id}', [CategoryChildController::class, 'update']); // sua thong tin
    Route::get('categoryChildbyid', [CategoryChildController::class, 'showbyCategoryId']); // sua thong tin
    Route::delete('categoryChild/{id}', [CategoryChildController::class, 'destroy']); // xoa thong tin

    //Khách hàng
    Route::get('customer', [CustomerController::class, 'index']); // lay thong toan bo thong tin
    Route::post('customer', [CustomerController::class, 'store']); // them moi thong tin
    Route::put('customer/{id}', [CustomerController::class, 'update']); // sua thong tin
    Route::delete('customer/{id}', [CustomerController::class, 'destroy']); // xoa thong tin

    Route::get('customertype', [CustomerTypeController::class, 'index']); // lay thong toan bo thong tin
    Route::post('customertype', [CustomerTypeController::class, 'store']); // them moi thong tin
    Route::put('customertype/{id}', [CustomerTypeController::class, 'update']); // sua thong tin
    Route::delete('customertype/{id}', [CustomerTypeController::class, 'destroy']); // xoa thong tin
    //Khách hàng
    Route::get('enterprise', [EnterpriseController::class, 'index']); // lay thong toan bo thong tin
    Route::post('enterprise', [EnterpriseController::class, 'store']); // them moi thong tin
    Route::put('enterprise/{id}', [EnterpriseController::class, 'update']); // sua thong tin
    Route::delete('enterprise/{id}', [EnterpriseController::class, 'destroy']); // xoa thong tin
    //Dac tinh san pham
    Route::get('specificities', [SpecificitieController::class, 'index']); // lay thong toan bo thong tin
    Route::post('specificities', [SpecificitieController::class, 'store']); // them moi thong tin
    Route::put('specificities/{id}', [SpecificitieController::class, 'update']); // sua thong tin
    Route::delete('specificities/{id}', [SpecificitieController::class, 'destroy']); // xoa thong tin
    //Loai nhan vien
    Route::get('employeeType', [EmployeeTypeController::class, 'index']); // lay thong toan bo thong tin
    Route::post('employeeType', [EmployeeTypeController::class, 'store']); // them moi thong tin
    Route::put('employeeType/{id}', [EmployeeTypeController::class, 'update']); // sua thong tin
    Route::delete('employeeType/{id}', [EmployeeTypeController::class, 'destroy']); // xoa thong tin
    //nhan vien
    Route::get('employee', [EmployeeController::class, 'index']); // lay thong toan bo thong tin
    Route::post('employee', [EmployeeController::class, 'store']); // them moi thong tin
    Route::put('employee/{id}', [EmployeeController::class, 'update']); // sua thong tin
    Route::delete('employee/{id}', [EmployeeController::class, 'destroy']); // xoa thong tin
    //don vi tinh
    Route::get('unit', [UnitController::class, 'index']); // lay thong toan bo thong tin
    Route::post('unit', [UnitController::class, 'store']); // them moi thong tin
    Route::put('unit/{id}', [UnitController::class, 'update']); // sua thong tin
    Route::delete('unit/{id}', [UnitController::class, 'destroy']); // xoa thong tin
    //gia
    Route::get('price', [PriceController::class, 'index']); // lay thong toan bo thong tin
    Route::post('price', [PriceController::class, 'store']); // them moi thong tin
    Route::put('price/{id}', [PriceController::class, 'update']); // sua thong tin
    Route::delete('price/{id}', [PriceController::class, 'destroy']); // xoa thong tin
    // phieu nhap
    Route::get('input', [InputController::class, 'index']); // lay thong toan bo thong tin
    Route::get('valueinput', [InputController::class, 'getlistValueInput']); // lay thong toan bo thong tin
    Route::post('input', [InputController::class, 'store']); // them moi thong tin
    Route::put('input/{id}', [InputController::class, 'update']); // sua thong tin
    Route::delete('input/{id}', [InputController::class, 'destroy']); // xoa thong tin


    // phieu nhap
    Route::get('warehouse', [WarehouseController::class, 'index']); // lay thong toan bo thong tin
    // Route::get('valueinput', [InputController::class, 'getlistValueInput']); // lay thong toan bo thong tin
    // Route::post('input', [InputController::class, 'store']); // them moi thong tin
    // Route::put('input/{id}', [InputController::class, 'update']); // sua thong tin
    // Route::delete('input/{id}', [InputController::class, 'destroy']); // xoa thong tin

    // phieu xuat
    Route::get('export', [ExportController::class, 'index']); // lay thong toan bo thong tin
    // Route::get('valueinput', [InputController::class, 'getlistValueInput']); // lay thong toan bo thong tin
    Route::post('export', [ExportController::class, 'store']); // them moi thong tin
    Route::post('exportFromInput', [ExportController::class, 'exportFromInput']); // them moi thong tin
    Route::put('export/{id}', [ExportController::class, 'update']); // sua thong tin
    Route::delete('export/{id}', [ExportController::class, 'destroy']); // xoa thong tin

    //Thanh toan
    Route::get('thanhtoanvau', [PaymentController::class, 'thanhtoanvau']); // lay thong toan bo thong tin



});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('register', [UserApiController::class, 'store']);

    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('password/reset', [ResetPasswordController::class, 'reset']);

    Route::post('email/verify/{user}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [VerificationController::class, 'resend']);

    Route::post('oauth/{driver}', [OAuthController::class, 'redirect']);
    Route::get('oauth/{driver}/callback', [OAuthController::class, 'handleCallback'])->name('oauth.callback');
});
