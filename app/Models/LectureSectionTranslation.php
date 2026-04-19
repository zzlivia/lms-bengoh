<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LectureSectionTranslation extends Model
{
    protected $fillable = [
        'sectionID',
        'locale',
        'title',
        'content',
    ];

    public function section()
    {
        return $this->belongsTo(LectureSection::class, 'sectionID');
    }
}
