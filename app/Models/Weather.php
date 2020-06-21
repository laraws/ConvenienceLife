<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    protected $table = 'weathers';
    protected $fillable = [
        'title', 'content', 'user_id', 'has_subscribed', 'city', 'type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
