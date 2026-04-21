<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class AssessmentQuestion extends Model
{
    use HasTranslations;

    protected $table = 'assessment_qs';
    protected $primaryKey = 'assQsID';

    public $translatable = ['courseAssQs'];

    public function options()
    {
        return $this->hasMany(AssessmentOption::class, 'assQsID');
    }
}