<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Translation extends Model
    {
        protected $table = 'translations'; // Points to your first image table

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