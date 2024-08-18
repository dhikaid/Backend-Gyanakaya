<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use function PHPSTORM_META\map;

class Materi extends Model
{
    use HasFactory;
    protected $table = 'materi';
    protected $guarded = [
        'id'
    ];
    protected $hidden = [
        'id',
        'id_kategori',
        'lanjutan',
        'created_at',
        'updated_at'
    ];

    public function modul(): HasMany
    {
        return $this->hasMany(Modul::class, 'id_materi', 'id');
    }
}
