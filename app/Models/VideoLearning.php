<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class VideoLearning extends Model
{
    use HasTranslations;
    protected $table = 'videolearning';
    protected $primaryKey = 'videoLearningID';
    protected $fillable = [
        'learningMaterialID',
        'videoLearningName',
        'videoLearningDesc',
        'videoLearningDuration',
        'videoLearningResolution'
    ];

}
