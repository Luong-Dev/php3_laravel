<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;
    public $primaryKey = ['product_id', 'user_id'];
    public $timestamps = true;
    protected  $attributes = [];
    protected $fillable = [
        'product_id', 'user_id'
    ];
}
