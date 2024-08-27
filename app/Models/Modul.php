<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Modul extends Model
{
    use HasFactory;
    protected $table = 'modul';
    protected $guarded = [
        'id'
    ];
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
        'id_materi'
    ];
    public function getCoverAttribute($value)
    {
        return url('storage/' . $value);
    }
    public function user(): HasMany
    {
        return $this->hasMany(ModulUser::class, 'id_modul', 'id');
    }
}
