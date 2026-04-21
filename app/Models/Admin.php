<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTranslations;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable; //enable factory usage and notifications
    use HasTranslations;
    protected $table = 'admin'; //table name
    protected $primaryKey = 'adminID'; //custom primary key
    protected $fillable = [ //attributes
        'adminName',
        'adminEmail',
        'adminPass',
        'adminRole'
    ];

    protected $hidden = ['adminPass',]; //hidden attributes
    protected $casts = ['adminPass' => 'hashed',];//auto hashed
    public function getAuthPassword() { return $this->adminPass; }
    public function getAuthIdentifierName(){return 'adminID';}

    public function announcements() { return $this->hasMany(Announcements::class, 'adminID', 'adminID'); }

    public function reports() { return $this->hasMany(Reports::class, 'generatedBy', 'adminID'); }

    public function stories() { return $this->hasMany(CommunityStory::class, 'adminID', 'adminID'); }
}
