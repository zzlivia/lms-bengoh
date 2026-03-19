<?php

namespace App\Models;

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
}
