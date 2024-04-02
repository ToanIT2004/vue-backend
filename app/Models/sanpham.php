<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sanpham extends Model
{
    use HasFactory;

    public function menu() {
        // Khóa ngoại đến idmenu của sản phẩm
        return $this->belongsTo(menu::class, 'idmenu');
    }

    public function color() {
        return $this->belongsTo(color::class, 'idcolor');
    }

    public function dungluong() {
        return $this->belongsTo(dungluong::class, 'idGB');
    }

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
