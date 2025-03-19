<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class YieldPercentageModifier extends Model
{
    protected $fillable = ['asset_id', 'value'];

    public function asset(): HasOne
    {
        return $this->hasOne(Asset::class);
    }
}
