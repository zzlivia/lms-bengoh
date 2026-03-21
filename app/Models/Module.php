<?php

namespace App\Models;

use App\Models\Course;
use App\Models\Lecture;
use App\Models\Mcqs;
use App\Models\Enrollment;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'module';
    protected $primaryKey = 'moduleID';
    protected $fillable = [
        'moduleName',
        'courseID'
    ];

    public function course()
    {
        //a module belongs to one course
        return $this->belongsTo(Course::class, 'courseID', 'courseID');
    }

    public function lectures()
    {
        return $this->hasMany(Lecture::class, 'moduleID', 'moduleID');
    }

    public function mcqs()
    {
        return $this->hasMany(Mcqs::class, 'moduleID', 'moduleID');
    }

    // calculate total duration of module
    public function totalDuration()
    {
        return $this->lectures->sum('lect_duration');
    }

    public function enrolment()
    {
        return $this->hasOne(Enrollment::class, 'moduleID', 'moduleID')
                    ->where('userID', auth()->id());
    }
}
