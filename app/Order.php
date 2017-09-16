<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = ['customer_id', 'notes', 'complete', 'total'];
    //protected $with = ['customer'];

//

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function orderedItems(){
        return $this->hasMany(OrderedItem::class);
    }

    public function orderedCakes(){
        return $this->hasMany(OrderedCake::class);
    }


}
