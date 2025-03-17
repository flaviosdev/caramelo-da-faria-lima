<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Http\Requests\PortfolioRequest;
use App\Models\Portfolio;
use App\Services\TransactionService;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function __construct(
        private readonly TransactionService $transactionService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(int $portfolioId, int $assetId)
    {
        return $this->transactionService->getByAssetId($assetId);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionRequest $request, $portfolioId, $assetId)
    {
        if ($assetId !== $request->get('asset_id')) {
            return response()->json(
                ['portfolio_id from url and body does not match'],
                400
            );
        }
        $requestBody = array_merge($request->all(), ['asset_id' => $assetId]);
        $savedTransaction = $this->transactionService->save($requestBody);

        return [
            'id' => $savedTransaction['id'],
            'asset_id' => $savedTransaction['asset_id'],
            'transaction_type_id' => $savedTransaction['transaction_type_id'],
            'date' => $savedTransaction['date'],
            'amount' => $savedTransaction['amount'],
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(int $portfolioId, int $asstetId, $transactionId)
    {
        $transaction = $this->transactionService->getById($transactionId);

        if (!$transaction) {
            return response()->json('Not Found')
                ->setStatusCode(404);
        }

        return [
            'id' => $transaction['id'],
            'asset_id' => $transaction['asset_id'],
            'transaction_type_id' => $transaction['transaction_type_id'],
            'date' => $transaction['date'],
            'amount' => $transaction['amount'],
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $portfolioId, int $assetId, int $transactionId)
    {
        $this->transactionService->delete($transactionId);
    }
}
