<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearningMaterials extends Model
{
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
