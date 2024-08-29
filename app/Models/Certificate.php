<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Certificate extends Model
{
    use HasFactory;
    protected $table = 'certificates';
    protected $guarded = [
        'id'
    ];
    protected $hidden = [
        'id',
        'id_user',
        'id_materi',
        // 'created_at',
        'updated_at'
    ];

    public function getSertifikatAttribute($value)
    {
        return url('storage/' . $value);
    }

    public function materi(): HasMany
    {
        return $this->hasMany(Materi::class, 'id', 'id_materi');
    }
}
