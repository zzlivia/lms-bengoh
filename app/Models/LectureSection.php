<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class LectureSection extends Model
{
    use HasTranslations;
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

}
