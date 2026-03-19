<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'coursefeedback';
    protected $primaryKey = 'feedbackID';
    protected $fillable = [
        'courseID',
        'courseRating'
    ];

    public function lecture()
    {
        return $this->belongsTo(Lecture::class, 'lectID', 'lectID');
    }

    public function video()
    {
        return $this->hasOne(VideoLearning::class, 'learningMaterialID', 'learningMaterialID');
    }

    public function pdf()
    {
        return $this->hasOne(PdfLearning::class, 'learningMaterialID', 'learningMaterialID');
    }
}
