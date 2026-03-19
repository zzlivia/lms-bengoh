<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearningMaterials extends Model
{
    protected $table = 'learningmaterials';
    protected $primaryKey = 'learningMaterialID';
    protected $fillable = [
        'lectID',
        'learningMaterialTitle',
        'learningMaterialDesc',
        'learningMaterialType',
        'storagePath'
    ];
}
