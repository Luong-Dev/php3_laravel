<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    public $incrementing = false;
    public $primaryKey = ['product_detail_id', 'user_id'];
    public $timestamps = true;
    protected  $attributes = [
        // 'quantity' => 1
    ];
    protected $fillable = [
        'product_detail_id', 'user_id', 'quantity'
    ];
}
