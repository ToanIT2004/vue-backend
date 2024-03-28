<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sanpham extends Model
{
    use HasFactory;

    protected $fillable = [
        'idmenu',
        'idcolor', 
        'idGB',
        'tensp', 
        'mota',
        'img',
        'img1',
        'img2',
        'img3',
        'dongia',
        'giamgia',
        'slton', 
    ];
}
