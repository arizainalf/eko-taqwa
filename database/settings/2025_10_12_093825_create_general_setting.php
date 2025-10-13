<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_name', 'Eko Taqwa');
        $this->migrator->add('general.email', 'admin@gmail.com');
        $this->migrator->add('general.maintenance_mode', false);
        $this->migrator->add('general.logo_path', '');
    }
};
