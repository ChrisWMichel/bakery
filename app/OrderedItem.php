<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderedItem extends Model
{
    protected $fillable = ['order_id', 'item_id', 'quantity'];
    protected $with = ['item'];

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function item(){
        return $this->belongsTo(Item::class);
    }
}
