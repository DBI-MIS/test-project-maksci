<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'task',
        'type_id',
        'due',
        'status'
    ];

    public function types(){
        return $this->belongsToMany(Type::class, 'task_type')->withTimestamps();
    }
}
