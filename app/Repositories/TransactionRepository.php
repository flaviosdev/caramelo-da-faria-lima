<?php

namespace App\Repositories;

use App\Models\Asset;
use App\Models\TransactionType;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\DB;

class TransactionRepository
{

    public function hasYieldToday(Asset $asset) {
        return DB::table('transactions')
            ->whereDate('created_at', Carbon::today())
            ->where('asset_id', $asset->id)
            ->where('transaction_type_id', TransactionType::YIELD)
            ->exists();
    }

    public function getLastTransactionOnDate(Asset $asset, CarbonInterface $date)
    {
        return DB::table('transactions')
            ->whereDate('created_at', $date)
            ->where('asset_id', $asset->id)
            ->latest()
            ->first();
    }

    public function getLastTransaction(Asset $asset)
    {
        return DB::table('transactions')
            ->where('asset_id', $asset->id)
            ->exists();
    }
}
