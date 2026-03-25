<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentMcqOption extends Model
{
    protected $fillable = [
        'assQsID',
        'optionText',
        'is_correct'
    ];
}
