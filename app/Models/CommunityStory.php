<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class CommunityStory extends Model
{
    use HasTranslations;
    protected $table = 'community_stories';
    protected $primaryKey = 'id';
    protected $fillable = [
        'adminID',
        'community_name',
        'title',
        'community_story',
        'community_image'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'adminID', 'adminID');
    }
}
