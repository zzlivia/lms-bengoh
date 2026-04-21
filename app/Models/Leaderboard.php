<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class Leaderboard extends Model
{
    use HasTranslations;
    protected $table = 'leaderboard';
    protected $primaryKey = 'leaderboardID';

    
}
