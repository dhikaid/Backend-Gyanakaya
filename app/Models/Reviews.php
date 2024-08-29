<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    use HasFactory;
    protected $table = 'reviews';
    protected $guarded = [
        'id'
    ];
    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];
}
