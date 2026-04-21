<?php

namespace App\Traits;

use App\Models\Translation;
use Illuminate\Support\Facades\App;

trait HasTranslations
{
    public function translations()
    {
        return $this->morphMany(Translation::class, 'translationable');
    }

    public function getTranslation($key)
    {
        $locale = App::getLocale();
        
        // Default language (English) returns the direct column value
        if ($locale === 'en') {
            return $this->{$key};
        }

        // Search for the translation in the polymorphic table
        $translation = $this->translations()
            ->where('locale', $locale)
            ->where('key', $key)
            ->first();

        return $translation ? $translation->value : $this->{$key};
    }
}