<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Express extends Model
{
    protected $table = 'expresses';
    protected $fillable = [
        'title', 'content', 'user_id', 'tracking_number', 'company_name_en', 'company_name',
        'sign_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
