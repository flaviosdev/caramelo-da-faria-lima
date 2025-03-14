<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = ['portfolio_id', 'name', 'asset_type_id'];
}
