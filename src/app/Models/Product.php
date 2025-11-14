<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'image',
        'description',
    ];
    // 季節（多対多）
    public function seasons()
    {
        return $this->belongsToMany(Season::class);
    }
}
