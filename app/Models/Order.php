<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['*'];

    protected $casts = [
        'created_at' =>'datetime:d/m/Y',
        'updated_at' =>'datetime:d/m/Y'
    ];
}
