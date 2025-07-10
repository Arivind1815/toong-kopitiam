<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
    'customer_name',
    'phone',
    'email',
    'total_amount',
    'status',
    'special_instructions', 
];

   public function items()
{
    return $this->hasMany(OrderItem::class);
}

}
