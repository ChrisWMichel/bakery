<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderedCake extends Model
{
    protected $fillable = ['order_id', 'cake_item_id', 'quantity'];
    protected $with = ['cakeItem'];

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function cakeItem(){
        return $this->belongsTo(CakeItem::class);
    }
}
