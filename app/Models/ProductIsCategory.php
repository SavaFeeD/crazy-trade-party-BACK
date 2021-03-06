<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductIsCategory extends Model
{
    use HasFactory;

    protected $fillable = [
      'product_id', 'category_id'
    ];

    public $timestamps = false;
}
