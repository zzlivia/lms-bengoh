<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class AssessmentOption extends Model
{
    use HasTranslations;

    protected $table = 'assessment_mcq_options';

    public $translatable = ['optionText'];
}