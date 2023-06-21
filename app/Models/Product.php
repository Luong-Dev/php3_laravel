<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use SoftDeletes;
    use HasFactory;
    public $timestamps = true;
    protected  $attributes = [
        'views' => 0,
        'long_description' => ''
    ];
    protected $fillable = [
        'product_category_id', 'name', 'short_description', 'long_description', 'views'
    ];
}
