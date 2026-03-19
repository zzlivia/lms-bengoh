<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcements extends Model
{
    protected $table = 'announcements';
    protected $primaryKey = 'announcementID';
    protected $fillable = [
        'announcementTitle',
        'announcementDetails',
        'adminID'
    ];
}
