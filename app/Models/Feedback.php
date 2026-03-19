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
}
