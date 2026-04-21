<?php

namespace App\Traits;

use App\Models\Translation;
use Illuminate\Support\Facades\App;

trait HasTranslations {
    public function translations() {
        return $this->morphMany(Translation::class, 'translationable');
    }

    public function getTranslation($column) {
        $locale = App::getLocale();
        // If locale is default (en), return the original column
        if ($locale == 'en') {
            return $this->{$column};
        }

        $translation = $this->translations
            ->where('locale', $locale)
            ->where('key', $column)
            ->first();

        return $translation ? $translation->value : $this->{$column};
    }
}