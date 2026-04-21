<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class LectureProgress extends Model
{
    use HasTranslations;
    protected $table = 'lectureprogress';

    protected $fillable = [
        'userID',
        'lectID',
        'completed_at'
    ];
}
