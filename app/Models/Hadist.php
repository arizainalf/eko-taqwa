<?php
namespace App\Models;

use App\Models\Tema;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hadist extends Model
{
    use HasFactory, HasUuids;

    protected $table   = 'hadist';
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
        return $this->belongsTo(Tema::class, 'tema_id');
    }
}
