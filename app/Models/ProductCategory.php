<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    public $timestamps = true;
    protected  $attributes = [
        'description' => '',
        'image_url' => '',
        'image_alt' => ''
    ];
    protected $fillable = [
        'name', 'description', 'image_url', 'image_alt'
    ];
}
