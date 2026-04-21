<?php

namespace App\Traits;

use App\Models\Translation;
use Illuminate\Support\Facades\App;

trait HasTranslations
{
    /**
     * Link the Model to the Translations table
     */
    public function translations()
    {
        return $this->morphMany(Translation::class, 'translationable');
    }

    /**
     * A helper function to get the translated value
     */
    public function getTranslation($key)
    {
        $locale = App::getLocale(); // Gets 'en' or 'ms'

        // Look for the translation in the database
        $translation = $this->translations
            ->where('locale', $locale)
            ->where('key', $key)
            ->first();

        // If found, return the translated value. 
        // If not found, return the original column value (default English).
        return $translation ? $translation->value : $this->$key;
    }
}