<?php

namespace App\Models;

use App\Models\Module;
use App\Models\LectureSection;
use App\Models\LearningMaterials;
use App\Models\Mcqs;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class Lecture extends Model
{
    use HasTranslations;
    protected $table = 'lecture';
    protected $primaryKey = 'lectID';
    protected $fillable = [
        //'lectID', 
        'moduleID', 
        'lectName', 
        'lect_duration'
    ];

    public function module()
    {
        return $this->belongsTo(Module::class, 'moduleID', 'moduleID');
    }

    public function sections()
    {
        return $this->hasMany(LectureSection::class, 'lectID', 'lectID')->orderBy('section_order');
    }

        public function materials()
    {
        return $this->hasMany(LearningMaterials::class, 'lectID', 'lectID');
    }

    public function mcqs()
    {
        return $this->hasMany(Mcqs::class, 'moduleID', 'moduleID');
    }
}
