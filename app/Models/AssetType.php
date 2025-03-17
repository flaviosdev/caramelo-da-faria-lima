<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetType extends Model
{
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }
}
