<?php

namespace App\Models;

use App\Models\Module;
use App\Models\LectureSection;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
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
}
