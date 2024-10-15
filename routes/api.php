<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;

Route::post('user/register', [UserController::class, 'store']);
Route::post('user/login', [UserController::class, 'auth']);

Route::get('company', [CompanyController::class, 'index']);
Route::get('company/{id}', [CompanyController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', function (Request $request) {
        return [
            'user' => $request->user(),
            'currentToken' => $request->bearerToken(),
        ];
    });

    Route::post('user/logout', [UserController::class, 'logout']);
    
    Route::post('company/store' , [CompanyController::class, 'store']);
    Route::delete('company/delete/{id}', [CompanyController::class, 'destroy']);

    Route::get('userAdmin', [UserController::class, 'index']);
    Route::delete('user/delete/{id}', [UserController::class, 'destroy']);
});
