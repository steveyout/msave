<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transactions extends Model
{
    use HasFactory;
    protected $fillable=[
        'amount',
        'receipt_number',
        'phone_number',
        'created_at',
        'updated_at'
    ];
}
