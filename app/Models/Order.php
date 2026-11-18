<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = 'orders';
    
   
    protected $primaryKey = 'order_id';
    
   
    public $incrementing = true;
    
   
    protected $keyType = 'int';
    
    
    public $timestamps = false;
    

    protected $guarded = [];
    

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }
}