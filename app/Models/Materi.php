<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

use function PHPSTORM_META\map;

class Materi extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'materi';
    protected $guarded = [
        'id'
    ];
    protected $hidden = [
        'id',
        'id_kategori',
        // 'lanjutan',
        'created_at',
        'updated_at'
    ];

    public function modul(): HasMany
    {
        return $this->hasMany(Modul::class, 'id_materi', 'id');
    }

    public function firstModul(): HasMany
    {
        return $this->hasMany(Modul::class, 'id_materi', 'id');
    }

    public function user(): HasMany
    {
        return $this->hasMany(MateriUser::class, 'id_materi', 'id_materi');
    }

    public function scopeSearch(Builder $query, string $search): void
    {
        $query->where('materi', 'like', '%' . $search . '%');
    }

    public function getCoverAttribute($value)
    {
        return url('storage/' . $value);
    }

    public function getLanjutanAttribute($value)
    {
        if ($value == true) {
            return true;
        } else {
            return false;
        }
    }
}
