<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $table = 'enrolmentcoursemodules';
    protected $primaryKey = 'enrolID';

    protected $fillable = [
        'userID',
        'courseID',
        'moduleID',
        'isCompleted',
        'inProgress'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'courseID', 'courseID');
    }
}
