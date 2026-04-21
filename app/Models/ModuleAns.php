<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class ModuleAns extends Model
{
    use HasTranslations;
    protected $table = 'moduleans';
    protected $primaryKey = 'ansID';
    protected $fillable = [
        'moduleQs_ID',
        'ansID_text',
        'ansCorrect'
    ];

    public function question()
    {
        //each choice belongs back to one question
        return $this->belongsTo(Mcqs::class, 'moduleQs_ID', 'moduleQs_ID');
    }
}
