<?php
namespace App\Models;

use App\Models\Chat;
use App\Models\Refleksi;
use App\Models\HasilKuis;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Device extends Model
{
    use HasFactory, HasUuids;

    protected $table   = 'device';
    protected $guarded = ['id'];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (! $model->id) {
                $model->id = Str::uuid();
            }
        });
    }
    public function refleksi()
    {
        return $this->hasMany(Refleksi::class, 'device_id');
    }
    public function hasilkuis()
    {
        return $this->hasMany(HasilKuis::class, 'device_id');
    }
    public function chat()
    {
        return $this->hasMany(Chat::class, 'device_id');
    }
}
