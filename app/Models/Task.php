<?php

namespace App\Models;

use App\Concerns\RecordHistory;
use App\Concerns\RecordsHistory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    use RecordsHistory;
    protected $fillable = [
        'task',
        'type_id',
        'due',
        'status'
    ];

    public function types(){
        return $this->belongsToMany(Type::class, 'task_type')->withTimestamps();
    }

    public function histories(){
        return $this->hasMany(History::class);
    }


    
}
