<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseAssessment extends Model
{
    protected $table = 'course_assessments';
    protected $primaryKey = 'courseAssID';

    protected $fillable = [
        'courseID',
        'courseAssTitle',
        'courseAssDesc'
    ];

    public function questions()
    {
        return $this->hasMany(AssessmentQuestion::class, 'courseAssID');
    }
}
