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
}
