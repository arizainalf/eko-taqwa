<?php
namespace App\Models;

use App\Models\Device;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Refleksi extends Model
{
    use HasFactory, HasUuids;
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (! $model->id) {
                $model->id = Str::uuid();
            }
        });
    }
    protected $table   = 'refleksi';
    protected $guarded = ['id'];

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }
}
