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
        if ($portfolioId !== $request->get('portfolio_id')) {
            return response()->json(
                ['portfolio_id from url and body does not match'],
                400
            );
        }
        $requestBody = array_merge($request->all(), ['asset_id' => $assetId]);
        $savedTransaction = $this->transactionService->save($requestBody);

        return [
            'id' => $savedTransaction['id'],
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
            return response()->json()
                ->setStatusCode(404);
        }

        return [
            'id' => $transaction['id'],
            'portfolio_id' => $transaction['portfolio_id'],
            'name' => $transaction['name'],
            'transaction_type' => $transaction['transaction_type'],
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
