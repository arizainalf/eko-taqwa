<?php
namespace App\Models;

use App\Models\Tema;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class JenisTema extends Model
{
    use HasFactory, HasUuids;

    protected $table   = 'jenis_tema';
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
    public function tema()
    {
        return $this->hasMany(Tema::class, 'jenistema_id');
    }
}
