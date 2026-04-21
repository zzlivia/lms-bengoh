<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class CourseAssessment extends Model
{
    use HasTranslations;
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

    public function course()
    {
        return $this->belongsTo(\App\Models\Course::class, 'courseID');
    }
}
