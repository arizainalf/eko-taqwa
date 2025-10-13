<?php
namespace App\Forms\Components;

use Filament\Forms\Components\Select;

class IconPicker extends Select
{
    protected string $view = 'forms.components.icon-picker';

    protected array $icons = [];

    public function icons(array $icons): static
    {
        $this->icons = $icons;

        $options = collect($icons)->mapWithKeys(function (string $icon) {
            // Contoh input: 'heroicon-o-chevron-right'

            // Ambil bagian setelah 'heroicon-o-' → 'chevron-right'
            $namePart = preg_replace('/^heroicon-[os]-/', '', $icon);

            // Ubah 'chevron-right' → 'Chevron Right'
            $label = str_replace('-', ' ', $namePart);
            $label = ucwords($label);

            return [$icon => $label];
        })->toArray();

        $this->options($options);

        return $this;
    }

    public function getIcons(): array
    {
        return $this->icons;
    }

    public function getViewData(): array
    {
        return array_merge(parent::getViewData(), [
            'icons' => $this->getIcons(),
        ]);
    }
}
