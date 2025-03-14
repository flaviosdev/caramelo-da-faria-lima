<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post(
    '/token/create',
    [\App\Http\Controllers\Token\CreateController::class, 'create']
);

Route::resource('/portfolios/{portfolioId}/assets', AssetController::class)->middleware('auth:sanctum');
Route::resource('/portfolios', PortfolioController::class)->middleware('auth:sanctum');
