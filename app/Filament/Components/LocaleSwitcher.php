<?php

namespace App\Filament\Components;

use Livewire\Component;

class LocaleSwitcher extends Component
{
    public string $currentLocale = 'az';

    public function mount(): void
    {
        $this->currentLocale = session('panel_locale', 'az');
    }

    public function setPanelLocale(string $locale): void
    {
        if (!in_array($locale, ['az', 'en', 'ru'])) {
            return;
        }

        session()->put('panel_locale', $locale);
        app()->setLocale($locale);
        $this->currentLocale = $locale;

        $this->dispatch('locale-changed');
    }

    public function render()
    {
        return view('filament.locale-switcher');
    }
}
