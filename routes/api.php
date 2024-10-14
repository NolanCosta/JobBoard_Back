<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdvertisementController;

Route::post('user/register', [UserController::class, 'store']);
Route::post('user/login', [UserController::class, 'auth']);
Route::get('/useradmin', [UserController::class, 'index']); 
Route::put('/userup', [UserController::class, 'update']);

Route::get('/annonce', [AdvertisementController::class, 'index']);  // Récupérer toutes les annonces
Route::post('/annonce', [AdvertisementController::class, 'store']); // Ajouter une nouvelle annonce
Route::delete('/userde/{id}', [UserController::class, 'destroy']); // Récupérer une annonce par son id


Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', function (Request $request) {
        return [
            'user' => $request->user(),
            'currentToken' => $request->bearerToken(),
        ];
    });

    Route::post('user/logout', [UserController::class, 'logout']);
});
