<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributeProductDetail extends Model
{
    use SoftDeletes;
    use HasFactory;
    public $incrementing = false;
    public $primaryKey = ['product_detail_id', 'product_attribute_id'];
    protected $table = 'product_attribute_product_detail';
    public $timestamps = true;
    // protected  $attributes = [];
    protected $fillable = [
        'product_attribute_id', 'product_detail_id'
    ];
}
