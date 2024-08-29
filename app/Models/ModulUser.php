<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModulUser extends Model
{
    use HasFactory;
    protected $table = 'modul_user';
    protected $guarded = [
        'id'
    ];
    protected $hidden = [
        'id',
        // 'created_at',
        'updated_at'
    ];
}
