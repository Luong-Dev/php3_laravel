<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected  $attributes = [
        // 'percent_value' => 0,
        // 'money_value' => 0,
        // 'order_value_total' => 0,
        // 'quantity' => -10,
        // 'quantity_used' => 0,
        // 'start_time' => "2022-12-30",
        // 'end_time' => "2100-10-10"
    ];
    protected $fillable = [
        'name', 'code', 'description', 'percent_value', 'money_value', 'order_value_total', 'quantity', 'quantity_used', 'start_time', 'end_time'
    ];
}
