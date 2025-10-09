<?php
namespace App\Models;

use App\Models\Device;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
    use HasFactory, HasUuids;

    protected $table   = 'chat';
    protected $guarded = ['id'];

    protected $casts = [
        'metadata' => 'array',
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
}
