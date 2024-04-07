<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class donhang extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'ho',
        'ten',
        'sdt',
        'diachi',
        'idkh',
    ];
}
