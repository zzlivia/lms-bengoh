<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class AssessmentMcqOption extends Model
{
    use HasTranslations;    
    
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
