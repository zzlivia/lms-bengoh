<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LectureProgress extends Model
{
    protected $table = 'lectureprogress';

    protected $fillable = [
        'userID',
        'lectID',
        'completed_at'
    ];
}
