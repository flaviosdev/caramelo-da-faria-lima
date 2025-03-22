<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class YieldIndex extends Model
{
    protected $table = 'yield_index';

    protected $fillable = ['name', 'formula', 'value'];

    public function assetType(): HasMany
    {
        return $this->hasMany(AssetType::class);
    }

    public function yieldPercentages(): HasMany
    {
        return $this->hasMany(YieldPercentage::class);
    }
}
