<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class checkouts extends Model
{
    use HasFactory;
    protected $fillable=[
        'checkout_request_id',
        'merchant_request_id',
    ];
}
