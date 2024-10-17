<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\FollowAdvertisementController;
use App\Http\Controllers\CompanyController;

Route::post('user/register', [UserController::class, 'store']);
Route::post('user/login', [UserController::class, 'auth']);

Route::get('company', [CompanyController::class, 'index']);
Route::get('company/{id}', [CompanyController::class, 'show']);

Route::get('/advertisement', [AdvertisementController::class, 'index']);
Route::get('/advertisement/{id}', [AdvertisementController::class, 'show']);

Route::post('followAdvertisement', [FollowAdvertisementController::class, 'store']);

Route::post('user/create', [UserController::class, 'store']);
Route::put('/user/{id}', [UserController::class, 'update']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', function (Request $request) {
        return [
            'user' => $request->user(),
            'currentToken' => $request->bearerToken(),
        ];
    });
    
    Route::post('user/logout', [UserController::class, 'logout']);
    Route::put('user/update/{id}', [UserController::class, 'update']);
    Route::delete('user/delete/{id}', [UserController::class, 'destroy']);
    
    Route::post('company/create' , [CompanyController::class, 'store']);
    Route::post('company/store' , [CompanyController::class, 'store']);
    Route::put('company/update/{id}', [CompanyController::class, 'update']);
    Route::delete('company/delete/{id}', [CompanyController::class, 'destroy']);

    Route::get('userAdmin', [UserController::class, 'index']);
    Route::delete('user/delete/{id}', [UserController::class, 'destroy']);

    Route::delete('/annonce/delete/{id}', [AdvertisementController::class, 'destroy']);
    Route::put('/annonce/{id}', [AdvertisementController::class, 'update']);
    Route::post('/annonce/create', [AdvertisementController::class, 'store']);

    Route::put('/company/{id}', [CompanyController::class, 'update']);

});
