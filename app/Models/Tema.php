<?php
namespace App\Models;

use App\Models\Ayat;
use App\Models\Kitab;
use App\Models\Video;
use App\Models\Hadist;
use App\Models\Kaidah;
use App\Models\JenisTema;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tema extends Model
{
    use HasFactory, HasUuids;

    protected $table   = 'tema';
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
    public function jenistema()
    {
        return $this->belongsTo(JenisTema::class, 'jenistema_id');
    }
    public function video()
    {
        return $this->hasMany(Video::class, 'tema_id');
    }
    public function kaidah()
    {
        return $this->hasMany(Kaidah::class, 'tema_id');
    }
    public function ayat()
    {
        return $this->hasMany(Ayat::class, 'tema_id');
    }
    public function hadist()
    {
        return $this->hasMany(Hadist::class, 'tema_id');
    }
    public function kitab()
    {
        return $this->hasMany(Kitab::class, 'tema_id');
    }
}
