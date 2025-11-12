<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passkey extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id',
        'credential_id',
        'public_key',
        'counter',
        'transports',
        'device_name',
        'last_used_at',
    ];

    protected $casts = [
        'transports' => 'array',
        'last_used_at' => 'datetime',
    ];

    public function user() {
        return $this->belongsTo( User::class );
    }
}