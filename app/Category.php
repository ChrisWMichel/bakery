<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'show_cat'];

    public function items(){
        return $this->hasMany(Item::class);
    }
}
