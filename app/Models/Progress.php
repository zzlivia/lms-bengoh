<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    protected $table = 'userprogress';
    protected $primaryKey = 'progressID';
    protected $fillable = [
        'userID',
        'courseID',
        'progressName',
        'progressStatus',
        'completionProgress',
        'lastAccessed' 
    ];
}
