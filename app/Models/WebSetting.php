<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebSetting extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected  $attributes = [
        'description' => ''
    ];
    protected $fillable = [
        'name', 'value', 'description'
    ];
}
