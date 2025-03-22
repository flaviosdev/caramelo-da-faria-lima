<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class YieldPercentage extends Model
{
    protected $fillable = ['asset_id', 'percentage'];

    protected $table = 'yield_percentage';

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function yieldPercentageModifier(): HasOne
    {
        return $this->hasOne(YieldPercentageModifier::class);
    }
}
