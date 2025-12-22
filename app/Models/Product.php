<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //$fillable adalah daftar kolom yang diizinkan untuk diisi secara manual (mass assigment)
    // mass assigment adalah kondisi ketika kita mengisi banyak kolom sekaligus dalam satu perintah
    protected $fillable = [
        'name', 'category_id', 'price', 'stock', 'description', 'image'
    ];

    public function category()
    {
        //setiap produk memiliki 1 kategori 
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        //1 produk bisa muncul di banyak order 
        return $this->hasMany(OrderItem::class);
    }
}
