<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoLearning extends Model
{
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
