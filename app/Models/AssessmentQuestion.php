<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class AssessmentQuestion extends Model
{
    use HasTranslations;
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
