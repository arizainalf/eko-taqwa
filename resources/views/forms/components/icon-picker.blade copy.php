<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="{ open: false, selected: @js($getState()) }">
        <button type="button" x-on:click="open = !open"
            class="fi-fo-select block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-start shadow-sm focus:border-primary-500 focus:ring-primary-500">
            <div class="flex items-center space-x-2">
                @if ($getState())
                    <x-filament::icon :icon="$getState()" class="w-5 h-5" />
                @endif
                <span>{{ $getState() ?: 'Pilih ikon...' }}</span>
            </div>
        </button>

        <div x-show="open" x-on:click.away="open = false" class="mt-1 z-10">
            <div class="absolute bg-white border rounded-lg shadow-lg max-h-60 overflow-y-auto w-full">
                @foreach ($getIcons() as $icon)
                    @if ($icon = str_starts_with($icon, 'o-'))
                        <button type="button"
                            x-on:click="selected = '{{ $icon }}'; $dispatch('input', '{{ $icon }}'); open = false"
                            class="w-full px-4 py-2 text-start hover:bg-gray-100 flex items-center space-x-2">
                            <x-filament::icon :icon="$icon" class="w-5 h-5" />
                            <span>{{ $icon }}</span>
                        </button>
                    @endif
                @endforeach
            </div>
        </div>

        <input type="hidden" {{ $applyStateBindingModifiers('wire:model') }}="{{ $getStatePath() }}"
            x-bind:value="selected" />
    </div>

    @if ($getState())
        <div class="mt-2 flex items-center space-x-2">
            <x-filament::icon :icon="$getState()" class="w-6 h-6 text-primary-600" />
            <span class="text-sm text-gray-600">{{ $getState() }}</span>
        </div>
    @endif
</x-dynamic-component>
