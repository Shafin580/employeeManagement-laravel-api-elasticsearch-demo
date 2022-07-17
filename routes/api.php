<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeDetailController;
use App\Http\Controllers\JobController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\PayrollController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [PassportAuthController::class, 'login']);

Route::prefix('/job')->group(function () {
    Route::post('/create', [JobController::class, 'create']);
});

Route::prefix('/department')->group(function () {
    Route::get('/', [DepartmentController::class, 'index']);
    Route::get('/{department}', [DepartmentController::class, 'show']);
});

Route::prefix('/employee')->group(function () {
    Route::get('/', [EmployeeController::class, 'index']);
    Route::post('/create', [EmployeeController::class, 'create']);
});

Route::prefix('/employeeDetail')->group(function () {
    Route::post('/create', [EmployeeDetailController::class, 'create']);
});

Route::prefix('/payroll')->group(function () {
    Route::post('/create', [PayrollController::class, 'create']);
});
