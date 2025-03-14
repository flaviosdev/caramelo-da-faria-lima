<?php

namespace App\Services;

use App\Models\Transaction;

class TransactionService
{
    public function save($transaction)
    {
        $savedTransaction = Transaction::create($transaction);

        return [
            'id' => $savedTransaction->id,
            'transaction_type_id' => $savedTransaction->transaction_type_id,
            'date' => $savedTransaction->created_at,
            'amount' => $savedTransaction->amount
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
            'transaction_type_id' => $transaction->transaction_type_id,
            'date' => $transaction->created_at,
            'amount' => $transaction->amount
        ];
    }

    public function getByAssetId(int $assetId)
    {
        $collection = Transaction::where('asset_id', $assetId)->get();
        return $collection->map(function ($item) {
            return [
                'id' => $item->id,
                'transaction_type_id' => $item->transaction_type_id,
                'date' => $item->created_at,
                'amount' => $item->name,
            ];
        });
    }

    public function update($id, $transaction)
    {
        // TODO: SHOULD I USE OR SHOULD I DELETE????? :-(
        $storedTransaction = Transaction::find($id);
        $storedTransaction->amount = $transaction['amount'];
        return (bool) $storedTransaction->save();
    }

    public function delete(string $id)
    {
        return Transaction::find($id)->delete();
    }
}
