<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected  $attributes = [
        'status' => 1
    ];
    protected $fillable = [
        'user_id', 'voucher_id', 'name', 'phone_number', 'address', 'ship', 'price_total', 'price_payment', 'payment_method', 'status','note'
    ];
}
