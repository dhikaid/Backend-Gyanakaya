<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory;
    protected $table = 'kategori';
    protected $guarded = [
        'id'
    ];
    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function getCoverAttribute($value)
    {
        return url('storage/' . $value);
    }

    public function materi(): HasMany
    {
        return $this->hasMany(Materi::class, 'id_kategori', 'id');
    }
}
