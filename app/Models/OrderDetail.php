<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    public $incrementing = false;
    public $primaryKey = ['product_detail_id', 'order_id'];
    public $timestamps = true;
    protected  $attributes = [
     
    ];
    protected $fillable = [
        'product_detail_id', 'order_id', 'quantity', 'price', 'price_total'
    ];
}
