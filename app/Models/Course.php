<?php

namespace App\Models;

use App\Models\Module;
use App\Models\Feedback;
use App\Models\Enrollment;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations; // Import the trait

class Course extends Model
{
    use HasTranslations;
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
