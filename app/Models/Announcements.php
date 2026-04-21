<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class Announcements extends Model
{
    use HasTranslations;
    protected $table = 'announcements';
    protected $primaryKey = 'announcementID';
    protected $fillable = [
        'announcementTitle',
        'announcementDetails',
        'adminID'
    ];
}
