<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contributions extends Model
{
    use HasFactory;
    protected $fillable=[
        'amount',
        'created_at',
        'updated_at'
    ];
}
