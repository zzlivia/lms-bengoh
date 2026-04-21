<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class LearningMaterials extends Model
{
    use HasTranslations;
    protected $table = 'learningmaterials';
    protected $primaryKey = 'learningMaterialID';
    protected $fillable = [
        'sectionID',
        'type',
        'content',
        'lectID',
        'learningMaterialTitle',
        'learningMaterialDesc',
        'learningMaterialType',
        'storagePath'
    ];
}
