<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    {{-- ✅ Satu-satunya elemen root sekarang adalah div ini --}}
    <div x-data="{ open: false }" class="relative">

        {{-- Tombol Select: Menggunakan kelas dari komponen Select Filament --}}
        <button type="button" x-on:click="open = !open"
            class="fi-select-input flex w-full items-center gap-x-3 rounded-lg bg-white px-3 py-2 text-sm text-gray-950 shadow-sm ring-1 ring-inset ring-gray-300 transition duration-75 focus:ring-2 focus:ring-primary-600 dark:bg-white/5 dark:text-white dark:ring-gray-700 dark:focus:ring-primary-500">

            <div class="flex-1 flex items-center gap-2 min-h-5">
                @if ($getState())
                    <x-filament::icon :icon="$getState()" class="h-5 w-5 text-gray-400 dark:text-gray-500" />
                    <span class="truncate">
                        {{ str($getState())->after('heroicon-')->replace('-', ' ')->title() }}
                    </span>
                @else
                    <span class="text-gray-500 dark:text-gray-400">Pilih ikon...</span>
                @endif
            </div>

            <x-filament::icon icon="heroicon-m-chevron-up-down" class="h-5 w-5 text-gray-400 dark:text-gray-500" />
        </button>

        {{-- Dropdown: Menggunakan kelas dari dropdown/panel Filament --}}
        <div x-cloak x-show="open" x-on:click.away="open = false" x-transition
            class="fi-select-dropdown-panel absolute z-10 mt-1 w-full rounded-lg bg-white p-1 shadow-lg ring-1 ring-gray-950/5 dark:bg-gray-800 dark:ring-white/20"
            style="max-height: 16rem; overflow-y: auto;">

            @php
                // ... (Kode PHP Anda tidak berubah)
                $groupedIcons = [];
                foreach ($getOptions() as $value => $label) {
                    $iconName = str($label)->after('heroicon-');
                    if ($iconName->startsWith(['academic', 'adjustments', 'archive'])) {
                        $group = 'General';
                    } elseif ($iconName->startsWith('arrow')) {
                        $group = 'Arrows';
                    } else {
                        $group = 'Other';
                    }
                    $groupedIcons[$group][$value] = $label;
                }
            @endphp

            @foreach ($groupedIcons as $groupName => $icons)
                <div class="fi-select-dropdown-header px-3 py-2">
                    <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">
                        {{ $groupName }}
                    </span>
                </div>

                @foreach ($icons as $value => $label)
                    <button type="button"
                        x-on:click="$wire.set('{{ $getStatePath() }}', '{{ $value }}'); open = false;"
                        class="fi-select-option flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm text-gray-950 transition-colors duration-75 hover:bg-gray-50 focus:bg-gray-50 dark:text-white dark:hover:bg-white/5 dark:focus:bg-white/5">

                        <x-filament::icon :icon="$value" class="h-5 w-5 text-gray-700 dark:text-gray-300" />
                        <span class="flex-1 truncate text-left">
                            {{ str($label)->after('heroicon-')->replace('-', ' ')->title() }}
                        </span>
                    </button>
                @endforeach
            @endforeach
        </div>

        {{-- 👇 Pindahkan <style> ke dalam <div> utama --}}
        <style>
            .fi-select-dropdown-panel::-webkit-scrollbar {
                width: 6px;
            }

            .fi-select-dropdown-panel::-webkit-scrollbar-track {
                background: #f1f5f9;
                border-radius: 0 0.5rem 0.5rem 0;
            }

            .fi-select-dropdown-panel::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 3px;
            }

            .fi-select-dropdown-panel::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
            }

            .dark .fi-select-dropdown-panel::-webkit-scrollbar-track {
                background: #374151;
            }

            .dark .fi-select-dropdown-panel::-webkit-scrollbar-thumb {
                background: #4b5563;
            }

            .dark .fi-select-dropdown-panel::-webkit-scrollbar-thumb:hover {
                background: #6b7280;
            }
        </style>
    </div>
</x-dynamic-component>
