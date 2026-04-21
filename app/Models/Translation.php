<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class Translation extends Model
{
    use HasFactory;
    use HasTranslations;
    protected $fillable = [
        'translationable_id',
        'translationable_type',
        'locale',
        'key',
        'value'
    ];

    /**
     * This allows the translation to link back to any model 
     */
    public function translationable()
    {
        return $this->morphTo();
    }
}