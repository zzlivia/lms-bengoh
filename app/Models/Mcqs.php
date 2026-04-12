<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mcqs extends Model
{
    protected $table = 'mcqs';
    protected $primaryKey = 'moduleQs_ID';
    protected $fillable = [
        'moduleID',
        'moduleQs',     // manual
        'question',     // AI
        'answer1',
        'answer2',
        'answer3',
        'answer4',
        'correct_answer'
    ];
    public function module()
    {
        return $this->belongsTo(Module::class, 'moduleID', 'moduleID');
    }
    public function answers()
    {
        //one uestion has many answer choices
        return $this->hasMany(ModuleAns::class, 'moduleQs_ID', 'moduleQs_ID');
    }
}
