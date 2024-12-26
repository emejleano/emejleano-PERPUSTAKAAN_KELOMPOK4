<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'message',
        'read_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
