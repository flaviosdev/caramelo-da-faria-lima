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

    public function assetType(): HasOne
    {
        return $this->hasOne(AssetType::class);
    }

    public function yieldPercentages(): HasMany
    {
        return $this->hasMany(YieldPercentage::class);
    }
}
