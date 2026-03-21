<?php

namespace App\Models;

use App\Models\Module;

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
}
