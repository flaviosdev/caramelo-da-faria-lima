<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class YieldPercentageModifier extends Model
{
    protected $fillable = ['asset_id', 'yield_percentage_id', 'yield_index_id', 'value'];

    public function asset(): HasOne
    {
        return $this->hasOne(Asset::class);
    }

    public function yieldPercentage(): HasOne
    {
        return $this->hasOne(YieldPercentage::class);
    }

    public function yieldIndex(): BelongsTo
    {
        return $this->belongsTo(YieldIndex::class);
    }
}
