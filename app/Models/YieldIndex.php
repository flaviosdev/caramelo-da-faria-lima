<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class YieldIndex extends Model
{
    protected $table = 'yield_index';

    protected $fillable = ['name', 'formula', 'value'];
    public function asset(): BelongsTo
    {
        return $this->belongsTo(AssetType::class);
    }
}
