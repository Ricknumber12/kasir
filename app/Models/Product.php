<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'product_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['product_id', 'name', 'category_id', 'price', 'stock', 'rating'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }
}