<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class Progress extends Model
{
    use HasTranslations;
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
