<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected  $attributes = [
        'status' => 1,
        'sale_price' => ''
    ];
    protected $fillable = [
        'product_id', 'regular_price', 'sale_price', 'quantity', 'status'
    ];
}
