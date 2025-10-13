<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div class="space-y-2">
        {{-- Search --}}
        <x-filament::input.wrapper>
            <x-filament::input x-data="{ search: '' }" x-model="search" placeholder="Cari ikon..." type="text"
                class="w-full" />
        </x-filament::input.wrapper>

        {{-- Grid Icon --}}
        <div x-data="{ search: '', selected: @entangle($attributes->wire('model')) }" class="grid grid-cols-6 gap-3 max-h-64 overflow-y-auto border rounded-lg p-3">
            @foreach ($getHeroicons() as $icon => $label)
            @php
                $icon = 'o-' . $icon;
                // dd($icon);
            @endphp
                <div class="flex flex-col items-center justify-center p-2 border rounded-lg cursor-pointer hover:bg-primary-100 transition"
                    :class="{ 'bg-primary-200 ring-2 ring-primary-500': selected === '{{ $icon }}' }"
                    @click="selected = '{{ $icon }}'"
                    x-show="search === '' || '{{ strtolower($label) }}'.includes(search.toLowerCase())">
                    <x-filament::icon :icon="$icon" class="w-6 h-6 text-primary-600" />
                    <span class="text-xs mt-1 text-gray-600">{{ $label }}</span>
                </div>
            @endforeach

        </div>

        {{-- Preview terpilih --}}
        <div class="mt-2" x-show="selected">
            <span class="text-sm text-gray-600">Ikon terpilih:</span>
            <div class="flex items-center space-x-2 mt-1">
                <x-filament::icon :icon="$getState()" class="w-6 h-6 text-primary-600" />
                <span class="text-sm">{{ $getState() }}</span>
            </div>
        </div>
    </div>
</x-dynamic-component>
