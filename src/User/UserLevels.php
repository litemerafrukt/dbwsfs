<?php

namespace litemerafrukt\User;

/**
 * Define user levels
 */
class UserLevels
{
    const ADMIN = 1;
    const USER = 2;
    const GUEST = 3;

    /**
     * Convert user level numeric to string
     */
    public static function levelToString(int $level) : string
    {
        switch ($level) {
            case 1:
                return 'Admin';
            case 2:
                return 'Användare';
            case 3:
                return 'Gäst';
            default:
                throw new Exception("User level to string error.");
        }
    }
}
