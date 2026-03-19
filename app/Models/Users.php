<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable; 
use Illuminate\Database\Eloquent\Model;

class Users extends Authenticatable 
{
    use HasFactory, Notifiable;
    protected $table = 'user';
    protected $primaryKey = 'userID';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['userName', 'userEmail', 'userPass', 'userRePass', 'authenticated', ];
    protected $hidden = [ 'userPass', 'userRePass', ];

    public function progress()
    {
        // track all user progress entries
        return $this->hasMany(Progress::class, 'userID', 'userID');
    }

    public function enrolments()
    {
        // view modules/courses the user is enrolled in
        return $this->hasMany(Enrollment::class, 'userID', 'userID');
    }

    public function leaderboard()
    {
        // an user has one spot in leaderboard
        return $this->hasOne(Leaderboard::class, 'userID', 'userID');
    }
}
