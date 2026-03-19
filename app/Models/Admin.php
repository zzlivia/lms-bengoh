<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Model
{
    use HasFactory, Notifiable; //enable factory usage and notifications

    protected $table = 'admin'; //table name
    protected $primaryKey = 'adminID'; //custom primary key
    public $incrementing = true; //auto increment allowed
    protected $keyType = 'int';

    protected $fillable = [ //attributes
        'adminName',
        'adminEmail',
        'adminPass',
        'adminRole'
    ];

    protected $hidden = ['adminPass',]; //hidden attributes
    protected $casts = ['adminPass' => 'hashed',];//auto hashed
}
