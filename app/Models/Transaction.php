<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = ['amount', 'balance', 'asset_id', 'transaction_type_id'];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }
}
