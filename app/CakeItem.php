<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CakeItem extends Model
{
    protected $fillable = ['category_cake_id', 'item', 'path', 'description', 'price', 'show', 'volume'];

    public function categoryCake(){
        return $this->belongsTo(CategoryCake::class);
    }

    public function orderedCakes(){
        return $this->hasMany(OrderedCake::class);
    }
}
