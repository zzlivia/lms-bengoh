<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentMcqOption extends Model
{
    protected $table = 'assessment_mcq_options';

    protected $fillable = [
        'assQsID',
        'optionText',
        'is_correct'
    ];

    public function question()
    {
        return $this->belongsTo(AssessmentQuestion::class, 'assQsID');
    }
}
