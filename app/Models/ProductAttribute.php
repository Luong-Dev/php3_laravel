<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use SoftDeletes;
    use HasFactory;
    public $timestamps = true;
    protected  $attributes = [
        'description_value' => ''
    ];
    protected $fillable = [
        'product_attribute_category_id', 'name', 'description_value'
    ];
}
