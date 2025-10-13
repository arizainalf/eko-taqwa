<?php
namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSetting extends Settings
{
    // ✅ Semua properti HARUS punya nilai default
    public string $logo_path      = '';
    public string $site_name      = 'My Website';
    public string $email          = 'admin@example.com';
    public bool $maintenance_mode = false;

    public static function group(): string
    {
        return 'general';
    }
}
