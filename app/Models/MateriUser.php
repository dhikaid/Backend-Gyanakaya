<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriUser extends Model
{
    use HasFactory;

    protected $table = 'materi_user';
    protected $guarded = [
        'id'
    ];
    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];
}
