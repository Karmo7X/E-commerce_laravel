<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'image',
        'description',
        'price',
        'quantity',
        'stock',
    ];

    // Automatically set the stock status based on the quantity before saving
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($product) {
            $product->stock = $product->quantity > 0;
        });
    }
    // Define relationships (if any)
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brands::class,'brand_id');
    }
}
