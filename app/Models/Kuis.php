<?php
namespace App\Models;

use App\Models\HasilKuis;
use App\Models\Pertanyaan;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kuis extends Model
{
    use HasFactory, HasUuids;

    protected $table   = 'kuis';
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
    public function pertanyaan()
    {
        return $this->hasMany(Pertanyaan::class, 'kuis_id');
    }
    public function hasilkuis()
    {
        return $this->hasMany(HasilKuis::class, 'kuis_id');
    }
}
