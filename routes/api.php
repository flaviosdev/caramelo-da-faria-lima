<?php

use App\Models\YieldIndex;
use App\Models\YieldPercentageModifier;
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

Route::post('/calculate', function (Request $request) {
    $aporte = (float)$request->get('aporte');
    $taxa = (float)$request->get('taxa');

    $taxaDiaria = pow(1 + ($taxa / 100) / 252, 1) - 1;
    $rendimento = round($aporte * $taxaDiaria, 2); // Arredonda já no cálculo
    $resultado = round($aporte + $rendimento, 2);

    $ir = round($rendimento * 0.225, 2);
    $rendimentoLiquido = round($rendimento - $ir, 2);

    return [
        'rendimento' => $rendimento,
        'resultado' => $resultado,
        'diferença' => $resultado - $aporte,
        'com imposto' => $rendimentoLiquido
    ];
});

Route::post('/calculate-yields', function (Request $request) {
    $yieldIndexes = YieldIndex::all(); // all updated indexes

    foreach ($yieldIndexes as $yieldIndex) {
        $modifier = YieldPercentageModifier::where('yield_index_id', $yieldIndex->id)->first();

        dd($modifier);
        }
});
