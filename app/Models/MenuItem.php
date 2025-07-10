<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [
        'name',
        'price',
        'category',
        'description',
        'image',
        'available',       
        'display_order',  
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}



