<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';

    protected $fillable = [
        'site_name',
        'email',
        'description',
        'maintenance_mode',
        'logo_path',
    ];

    protected $casts = [
        'maintenance_mode' => 'boolean',
    ];

    // Singleton: selalu ambil record pertama
    public static function instance(): self
    {
        return static::firstOrCreate([]);
    }
}
