<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentQuestion extends Model
{
    protected $table = 'assessment_qs';    
    protected $primaryKey = 'assQsID';

    protected $fillable = [
        'courseAssID',
        'courseAssQs',
        'courseAssType'
    ];

    public function options()
    {
        return $this->hasMany(AssessmentMcqOption::class, 'assQsID');
    }
}
