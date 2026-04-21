<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class PdfLearning extends Model
{
    use HasTranslations;
    protected $table = 'pdflearning';
    protected $primaryKey = 'pdfLearningID';
    protected $fillable = [
        'learningMaterialID',
        'pdfLearningName',
        'pdfLearningDesc',
        'pdfLearningPages',
        'pdfLearningSizes'
    ];
}
