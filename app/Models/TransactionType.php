<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    const YIELD = 2;
    protected $fillable = ['name'];
}
