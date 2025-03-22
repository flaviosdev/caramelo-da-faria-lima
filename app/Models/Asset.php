<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Asset extends Model
{
    protected $fillable = ['portfolio_id', 'name', 'asset_type_id'];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class);
    }

    public function assetType(): BelongsTo
    {
        return $this->belongsTo(AssetType::class);
    }

    public function yieldIndex(): BelongsTo
    {
        return $this->belongsTo(YieldIndex::class);
    }

    public function yieldPercentage(): HasOne
    {
        return $this->hasOne(YieldPercentage::class);
    }

    public function yieldPercentageModifier(): HasOne
    {
        return $this->hasOne(YieldPercentageModifier::class);
    }
}
