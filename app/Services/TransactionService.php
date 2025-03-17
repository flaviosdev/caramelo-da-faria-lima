<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    public function save($transaction)
    {
        $transaction['balance'] = 0;
        if ($lastTransaction = DB::table('transactions')->latest()->first()) {
            $transaction['balance'] = $transaction['amount'] + $lastTransaction->balance;
        }

        $savedTransaction = Transaction::create($transaction);

        return [
            'id' => $savedTransaction->id,
            'asset_id' => $savedTransaction->asset_id,
            'transaction_type_id' => $savedTransaction->transaction_type_id,
            'date' => $savedTransaction->created_at,
            'amount' => (float)$savedTransaction->amount,
            'balance' => (float)$savedTransaction->balance,
        ];
    }

    public function getById(int $id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return false;
        }

        return [
            'id' => $transaction->id,
            'asset_id' => $transaction->asset_id,
            'transaction_type_id' => $transaction->transaction_type_id,
            'date' => $transaction->created_at,
            'amount' => (float)$transaction->amount,
            'balance' => (float)$transaction->balance,
        ];
    }

    public function getByAssetId(int $assetId)
    {
        $collection = Transaction::where('asset_id', $assetId)
            ->orderBy('created_at', 'desc')
            ->get();
        return $collection->map(function ($item) {
            return [
                'id' => $item->id,
                'asset_id' => $item->asset_id,
                'transaction_type_id' => $item->transaction_type_id,
                'date' => $item->created_at,
                'amount' => (float)$item->amount,
                'balance' => (float)$item->balance, // todo: show in all transactions????
            ];
        });
    }

    public function update($id, $transaction)
    {
        // TODO: SHOULD I USE OR SHOULD I DELETE????? :-(
        $storedTransaction = Transaction::find($id);
        $storedTransaction->amount = $transaction['amount'];
        return (bool)$storedTransaction->save();
    }

    public function delete(string $id)
    {
        return Transaction::find($id)->delete();
    }
}
