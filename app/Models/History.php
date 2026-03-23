<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = [
        'task_id',
        'action',
        'old',
        'new'
    ];

     protected $casts = [
        'old' => 'array',
        'new' => 'array'
    ];
}
