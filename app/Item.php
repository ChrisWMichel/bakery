<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['category_id', 'item', 'path', 'description', 'price', 'show', 'volume'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function orderedItems(){
        return $this->hasMany(OrderedItem::class);
    }
}
