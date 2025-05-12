<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'desc',
        'value',
        'date',
        'category_id',
        'type',
        'recurrent',
        'user_id',
    ];
}
