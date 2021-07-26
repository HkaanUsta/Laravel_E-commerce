<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function productCount(){
        return $this->hasMany('App\Models\Product','category_id','id')->count();
    }
}
