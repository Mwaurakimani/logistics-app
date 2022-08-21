<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['*'];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y',
        'updated_at' => 'datetime:d/m/Y'
    ];

    public function procurements(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Procurement::class, 'order_id', 'id');
    }

    public function finance(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Finance::class, 'order_id', 'id');
    }
}
