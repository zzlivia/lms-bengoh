<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $table = 'lecture';
    protected $primaryKey = 'lectID';
    protected $fillable = [
        'lectID', 
        'moduleID', 
        'lectName', 
        'lect_duration'
    ];
}
