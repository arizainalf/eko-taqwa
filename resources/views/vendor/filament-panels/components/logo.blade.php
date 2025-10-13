@php
    use Illuminate\Support\Arr;

    $brandName = filament()->getBrandName();
    $brandLogo = filament()->getBrandLogo();
    $brandLogoHeight = filament()->getBrandLogoHeight() ?? '1.5rem';
    $darkModeBrandLogo = filament()->getDarkModeBrandLogo();
    $hasDarkModeBrandLogo = filled($darkModeBrandLogo);

    $getLogoContainerClasses = fn(): string => Arr::toCssClasses([
        'fi-logo-container flex items-center gap-2',
    ]);

    $getLogoClasses = fn(): string => Arr::toCssClasses([
        'fi-logo',
    ]);

    $logoStyles = "height: {$brandLogoHeight}";
@endphp

<div {{ $attributes->class([$getLogoContainerClasses()]) }}>
    {{-- Logo --}}
    @if ($brandLogo instanceof \Illuminate\Contracts\Support\Htmlable)
        <div
            {{
                $attributes
                    ->class([$getLogoClasses(), 'object-contain'])
                    ->style([$logoStyles])
            }}
        >
            {{ $brandLogo }}
        </div>
    @elseif (filled($brandLogo))
        <img
            alt="{{ __('filament-panels::layout.logo.alt', ['name' => $brandName]) }}"
            src="{{ $brandLogo }}"
            {{
                $attributes
                    ->class([$getLogoClasses(), 'object-contain max-h-8'])
                    ->style([$logoStyles])
            }}
        />
    @endif

    {{-- Nama Brand di samping logo --}}
    <span class="fi-logo-text text-base font-semibold text-gray-900 dark:text-white truncate">
        {{ $brandName }}
    </span>
</div>
