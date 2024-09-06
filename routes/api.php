<?php

use App\Http\Controllers\API\AgendaController;
use App\Http\Controllers\API\GalleryController;
use App\Http\Controllers\API\InfoController;
use App\Http\Controllers\API\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});
         
Route::middleware('auth:sanctum')->group( function () {
    Route::controller(RegisterController::class)->group(function(){
        Route::post('logout', 'logout');
    });
    Route::resource('gallery', GalleryController::class);
    Route::resource('info', InfoController::class);
    Route::resource('agenda', AgendaController::class);
});
