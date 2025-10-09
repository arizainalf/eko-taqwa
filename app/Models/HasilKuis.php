<?php
namespace App\Models;

use App\Models\Device;
use App\Models\Kuis;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class HasilKuis extends Model
{
    use HasFactory, HasUuids;

    protected $table   = 'hasil_kuis';
    protected $guarded = ['id'];

    protected $casts = [
        'jawaban' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (! $model->id) {
                $model->id = Str::uuid();
            }
        });
    }

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }
    public function kuis()
    {
        return $this->belongsTo(Kuis::class, 'kuis_id');
    }
}
