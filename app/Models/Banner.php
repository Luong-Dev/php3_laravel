<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use SoftDeletes;
    use HasFactory;
    public $timestamps = true;
    protected  $attributes = [];
    protected $fillable = [
        'image_url', 'image_alt', 'location', 'level'
    ];
}
