<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [""];

    public function income(){
        return $this->hasMany(Income::class);
    }

    public function outcome(){
        return $this->hasMany(Income::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
