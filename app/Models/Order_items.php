<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_items extends Model
{
    use HasFactory;
    protected $fillable=[
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];



        public function product(){
        return $this->belongsTo(Products::class,'product_id');
    }
    public function order(){
        return $this->belongsTo(Order::class,'order_id');
    }

}
