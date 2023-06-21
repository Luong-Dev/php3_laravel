<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttributeCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = true;
    protected  $attributes = [
        'description' => ''
    ];
    protected $fillable = [
        'name', 'description'
    ];
}
