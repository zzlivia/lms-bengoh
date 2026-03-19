<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityStory extends Model
{
    protected $table = 'community_stories';
    protected $primaryKey = 'id';
    protected $fillable = [
        'adminID',
        'community_name',
        'title',
        'community_story',
        'community_image'
    ];
}
