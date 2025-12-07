<?php

namespace App\Livewire;

use Illuminate\Support\Facades\App;
use Livewire\Component;

class LanguageSelector extends Component
{
    public function switchLocale(string $locale)
    {
        App::setLocale($locale);
        session()->put('locale', $locale);
        cookie()->queue(cookie('locale', $locale, 525600));

        return redirect(request()->header('Referer') ?? '/');
    }

    public function render()
    {
        return view('livewire.language-selector', [
            'currentLocale' => App::getLocale(),
        ]);
    }
}
