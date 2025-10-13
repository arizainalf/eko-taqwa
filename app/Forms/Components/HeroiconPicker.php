<?php
namespace App\Forms\Components;

use Filament\Forms\Components\Field;

class HeroiconPicker extends Field
{
    protected string $view = 'forms.components.heroicon-picker';

    public function getHeroicons(): array
    {
        $reflect = new \ReflectionClass(\Filament\Support\Icons\Heroicon::class);

        return collect($reflect->getConstants())
            ->mapWithKeys(function ($icon, $key) {
                // Kalau enum (Heroicon), ambil value string-nya
                $iconValue = is_object($icon) ? $icon->value : $icon;

                // Tidak perlu ubah prefix — value sudah valid
                return [$iconValue => str($key)->replace('_', ' ')->title()];
            })
            ->toArray();
    }
}
