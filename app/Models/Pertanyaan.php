<?php
namespace App\Models;

use App\Models\Kuis;
use Illuminate\Support\Str;
use App\Models\OpsiPertanyaan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pertanyaan extends Model
{
    use HasFactory, HasUuids;

    protected $table   = 'pertanyaan';
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
    public function kuis()
    {
        return $this->belongsTo(Kuis::class, 'kuis_id');
    }
    public function opsipertanyaan()
    {
        return $this->hasMany(OpsiPertanyaan::class, 'pertanyaan_id');
    }
}
