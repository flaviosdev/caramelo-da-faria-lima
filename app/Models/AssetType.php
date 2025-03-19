<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AssetType extends Model
{
    protected $fillable = ['yield_index_id', 'name'];
    public function asset(): HasMany
    {
        return $this->hasMany(Asset::class);
    }
}
