<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use SoftDeletes;
    use HasFactory;
    public $timestamps = true;
    protected  $attributes = [
        'image_alt' => '',
    ];
    protected $fillable = [
        'product_id', 'image_url', 'image_alt', 'level'
    ];
}
