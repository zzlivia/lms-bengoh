<?php

namespace App\Models;

use App\Models\Module;
use App\Models\Feedback;
use App\Models\Enrollment;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'course';
    protected $primaryKey = 'courseID';
    protected $fillable = [
        'courseCode',
        'courseName',
        'courseAuthor',
        'courseDesc',
        'courseCategory',
        'courseLevel',
        'courseDuration',
        'isAvailable',
        'courseImg'
    ];

    public function modules()
    {
        //a course has many modules
        return $this->hasMany(Module::class, 'courseID', 'courseID'); //modules.lectures.sections
    }

    public function feedback()
    {
        //a course has many course feedback ratings
        return $this->hasMany(Feedback::class, 'courseID', 'courseID');
    }

    public function enrolments()
    {
        return $this->hasMany(Enrollment::class, 'courseID', 'courseID');
    }
}
