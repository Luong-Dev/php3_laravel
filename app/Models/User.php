<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $timestamps = true;
    protected $dates = ['birth_of_date'];
    protected  $attributes = [
        'phone_number' => '',
        'birth_of_date' => '2023-10-10',
        'gender' => '', //comment lại sau khi có trường thêm dữ liệu
        'role' => 5,
        'status' => 1
    ];


    protected $fillable = [
        'last_name', 'first_name', 'phone_number', 'email', 'password', 'birth_of_date', 'gender', 'address', 'role', 'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
