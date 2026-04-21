<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LectureSection extends Model
{
    protected $table = 'lecture_sections';
    protected $primaryKey = 'sectionID';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'lectID',
        'section_title',
        'section_type',
        'section_content',
        'section_file',
        'section_order'
    ];

    public function lecture(){return $this->belongsTo(Lecture::class, 'lectID', 'lectID');}

    public function translations()
    {
        // foreign_key is sectionID, local_key is sectionID
        return $this->hasMany(LectureSectionTranslation::class, 'sectionID', 'sectionID');
    }
}
