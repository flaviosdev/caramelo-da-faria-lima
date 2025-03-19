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
    public function yieldIndex(): HasOne
    {
        return $this->hasOne(YieldIndex::class);
    }

    public function yieldPercentages(): HasMany
    {
        return $this->hasMany(YieldPercentage::class);
    }

    public function yieldPercentageModifier(): HasOne
    {
        return $this->hasOne(YieldPercentageModifier::class);
    }
}
