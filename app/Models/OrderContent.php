<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderContent extends Model
{
    protected $fillable = ['content'];

    public function order()
    {
        $this->belongsTo(Order::class);
    }
}
