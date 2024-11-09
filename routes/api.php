<?php

use App\Http\Controllers\PackageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(PackageController::class)->group(function(){
    Route::get('/packages','index');
    Route::post('/packages','store');
    Route::get('/packages/{package}','show');
    Route::patch('/packages/{package}','update');
});

