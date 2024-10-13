<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'status',        // Enum: pending, processing, completed, cancelled
        'user_id',       // Reference to user
        'location_id',   // Reference to location
        'total_price',   // Total price of the order
        'date_of_delivery', // Date of delivery
        'quantity',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
    public function items(){
      return  $this->hasMany(Order_items::class,'order_id');

    }
}
