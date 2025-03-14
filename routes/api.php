<?php

use App\Http\Controllers\{AssetController, PortfolioController, TransactionController};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post(
    '/token/create',
    [\App\Http\Controllers\Token\CreateController::class, 'create']
);

Route::resource('/portfolios/{portfolioId}/assets/{assetId}/transactions', TransactionController::class)->middleware('auth:sanctum');
Route::resource('/portfolios/{portfolioId}/assets', AssetController::class)->middleware('auth:sanctum');
Route::resource('/portfolios', PortfolioController::class)->middleware('auth:sanctum');
