<?php
namespace App\Models;

use App\Models\Cp;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Fase extends Model
{
    use HasFactory, HasUuids;

    protected $table   = 'fase';
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
    public function cp()
    {
        return $this->hasMany(Cp::class, 'fase_id');
    }
}
