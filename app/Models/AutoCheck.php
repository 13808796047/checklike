<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutoCheck extends Model
{
    protected $fillable = ['user_id', 'content_before', 'content_after'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
