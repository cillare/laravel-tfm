<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ObservationController;
use App\Http\Controllers\AuthController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('users', UserController::class);

Route::get('observations', [ObservationController::class, 'index']);
Route::get('observations/{id}', [ObservationController::class, 'show']);
Route::post('observations', [ObservationController::class, 'store'])->middleware('auth:sanctum');
Route::put('observations/{id}', [ObservationController::class, 'update'])->middleware('auth:sanctum');
Route::delete('observations/{id}', [ObservationController::class, 'destroy'])->middleware('auth:sanctum');


Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    /*     Route::get('/protected', function () {
        return response()->json(['message' => 'You are authenticated']);
    }); */
});
