<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class Reports extends Model
{
    use HasTranslations;
    protected $table = 'reports';
    protected $primaryKey = 'reportID';
}