<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserIpWhitelist extends Model
{
    protected $table = 'user_ip_whitelist';
    
    protected $fillable = [
        'user_id',
        'ip_address',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function isIpAllowed(int $userId, string $ipAddress): bool
    {
        return self::where('user_id', $userId)
            ->where('ip_address', $ipAddress)
            ->where('is_active', true)
            ->exists();
    }
}