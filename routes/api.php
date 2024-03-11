<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('departments')
    ->controller(DepartmentController::class)
    ->group(function () {

        Route::get('', 'index');

        Route::get('{department}/employees', 'employees');

});

Route::post('registration', [RegisterController::class, 'registration']);

Route::get('qr', [RegisterController::class, 'qr'])->middleware(['moonshine'])->name('qr');

Route::get('pdf/{employee}/{uuid}', [RegisterController::class, 'download'])->name('download');
