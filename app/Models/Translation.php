<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    //tells Laravel it is allowed to insert data into these columns
    protected $fillable = [
        'translatable_type',
        'translatable_id',
        'locale',
        'key',
        'value'
    ];

    public function translatable()
    {
        return $this->morphTo();
    }
}
?>