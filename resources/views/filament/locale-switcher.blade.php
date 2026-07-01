<div class="flex items-center gap-1 px-3">
    @foreach (['az' => 'AZ', 'en' => 'EN', 'ru' => 'RU'] as $key => $label)
        <button
            type="button"
            wire:click="setPanelLocale('{{ $key }}')"
            class="filament-locale-btn text-sm font-bold tracking-wider px-3 py-1.5 rounded-lg transition shadow-sm
                {{ $currentLocale === $key
                    ? 'bg-primary-500 text-white shadow-primary-500/30'
                    : 'bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700' }}"
        >
            {{ $label }}
        </button>
    @endforeach
</div>
