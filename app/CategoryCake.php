<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryCake extends Model
{
    protected $fillable = ['name', 'show_cat'];

    public function items(){
        return $this->hasMany(CakeItem::class);
    }
}
