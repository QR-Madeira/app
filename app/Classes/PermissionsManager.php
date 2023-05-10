<?php

namespace App\Classes;

use App\Models\User;

final class PermissionsManager
{
    public const P_ZERO = 0x0;

    public const P_VIEW_ATTRACTION = 0x1 << 0;
    public const P_CREATE_ATTRACTION = 0x1 << 1;
    public const P_UPDATE_ATTRACTION = 0x1 << 2;
    public const P_DELETE_ATTRACTION = 0x1 << 3;
    public const P_ALL_ATTRACTION = self::P_VIEW_ATTRACTION
        | self::P_CREATE_ATTRACTION
        | self::P_UPDATE_ATTRACTION
        | self::P_DELETE_ATTRACTION;

    public const P_VIEW_USER = 0x1 << 4;
    public const P_CREATE_USER = 0x1 << 5;
    public const P_UPDATE_USER = 0x1 << 6;
    public const P_DELETE_USER = 0x1 << 7;
    public const P_ALL_USER = self::P_VIEW_USER
        | self::P_CREATE_USER
        | self::P_UPDATE_USER
        | self::P_DELETE_USER;

    public const P_ALL = self::P_ALL_ATTRACTION | self::P_ALL_USER;

    public static function check(User $u, int $permissions): bool
    {
        return ($u->permissions & $permissions) === $permissions;
    }

    public static function grant(User &$u, int ...$permissions): bool
    {
        foreach ($permissions as $p) {
            $u->permissions |= $p;
        }

        return $u->update();
    }

    public static function revoke(User &$u, int ...$permissions): bool
    {
        foreach ($permissions as $p) {
            $u->permissions &= ~$p;
        }

        return $u->update();
    }
}
