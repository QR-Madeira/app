<?php

namespace App\Auth;

use App\Models\User;

const P_ZERO = 0x0;

const P_VIEW_ATTRACTION = 0x1 << 0;
const P_MANAGE_ATTRACTION = (0x1 << 1) | P_VIEW_ATTRACTION;

const P_VIEW_USER = 0x1 << 2;
const P_MANAGE_USER = (0x1 << 3) | P_VIEW_USER;

const P_ALL = P_MANAGE_ATTRACTION | P_MANAGE_USER;

function check(User $u, int $permissions): bool
{
    return $u->super ?: (($u->permissions & $permissions) === $permissions);
}

function checkOrThrow(User $u, int $permissions): bool
{
    if (!check($u, $permissions)) {
        throw new NoPermissionsException($u, $permissions);
    }

    return true;
}

function grant(User &$u, int ...$permissions): bool
{
    foreach ($permissions as $p) {
        $u->permissions |= $p;
    }

    return $u->save();
}

function revoke(User &$u, int ...$permissions): bool
{
    foreach ($permissions as $p) {
        $u->permissions &= ~$p;
    }

    return $u->save();
}

function getPermissionsHash(): array
{
    return [
        "view_attractions" => P_VIEW_ATTRACTION,
        "manage_attractions" => P_MANAGE_ATTRACTION,
        "view_users" => P_VIEW_USER,
        "manage_users" => P_MANAGE_USER,
    ];
}

function getPermissionKey(int $permission): ?string
{
    foreach (getPermissionsHash() as $k => $v) {
        if ($v === $permission) {
            return $k;
        }
    }

    return null;
}
