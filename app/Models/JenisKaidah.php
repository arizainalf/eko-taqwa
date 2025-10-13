<?php
namespace App\Models;

use App\Models\Kaidah;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisKaidah extends Model
{
    use HasFactory, HasUuids;

    protected $table   = 'jenis_kaidah';
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
    public function kaidah()
    {
        return $this->hasMany(Kaidah::class, 'jenis_kaidah_id');
    }
}
