<?php

namespace App\Repositories;

use App\Models\Asset;
use App\Models\TransactionType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionRepository
{

    public function hasYieldToday(Asset $asset) {
        return DB::table('transactions')
            ->whereDate('created_at', Carbon::today())
            ->where('asset_id', $asset->id)
            ->where('transaction_type_id', TransactionType::YIELD) // Usa constante ou enum
            ->exists();
    }
}
