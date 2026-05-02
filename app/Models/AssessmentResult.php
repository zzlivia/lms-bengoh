<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class AssessmentResult extends Model
{
    use HasTranslations;
    protected $primaryKey = 'id';
    protected $fillable = ['userID','moduleID','score','status'];
    public $incrementing = true;
    protected $keyType = 'int';

    public function user()
    {
        return $this->belongsTo(Users::class, 'userID', 'userID');
    }
}