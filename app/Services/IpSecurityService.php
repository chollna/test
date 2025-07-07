<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserIpWhitelist;
use Illuminate\Http\Request;

class IpSecurityService
{
    public function validateUserIp(User $user, string $ipAddress): bool
    {
        // Skip IP validation for super admin or if no whitelist exists
        if ($this->shouldSkipValidation($user)) {
            return true;
        }

        return UserIpWhitelist::isIpAllowed($user->id, $ipAddress);
    }

    public function getClientIp(Request $request): string
    {
        $ipKeys = [
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_REAL_IP',
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        ];

        foreach ($ipKeys as $key) {
            if (!empty($_SERVER[$key])) {
                $ips = explode(',', $_SERVER[$key]);
                return trim($ips[0]);
            }
        }

        return $request->ip();
    }

    public function addIpToWhitelist(int $userId, string $ipAddress, string $description = null): UserIpWhitelist
    {
        return UserIpWhitelist::updateOrCreate(
            [
                'user_id' => $userId,
                'ip_address' => $ipAddress
            ],
            [
                'description' => $description,
                'is_active' => true
            ]
        );
    }

    public function removeIpFromWhitelist(int $userId, string $ipAddress): bool
    {
        return UserIpWhitelist::where('user_id', $userId)
            ->where('ip_address', $ipAddress)
            ->delete() > 0;
    }

    private function shouldSkipValidation(User $user): bool
    {
        // Skip validation if user is super admin or has no IP restrictions
        return $user->hasRole('super-admin') || 
               !$user->ipWhitelist()->where('is_active', true)->exists();
    }
}