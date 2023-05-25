<?php

namespace App\Auth;

use App\Models\User;

const P_ZERO = 0x0;

const P_MANAGE_SITE = 0x1 << 0;
const P_VIEW_ATTRACTION = 0x1 << 1;
const P_MANAGE_ATTRACTION = (0x1 << 2) | P_VIEW_ATTRACTION;

const P_VIEW_USER = 0x1 << 3;
const P_MANAGE_USER = (0x1 << 4) | P_VIEW_USER;

const P_ALL = P_MANAGE_ATTRACTION | P_MANAGE_USER;

function check(User $u, int $permissions, bool $active = true): bool
{
    return $active
        ? ($u->active
            && ($u->super ?: (($u->permissions & $permissions) === $permissions)))
        : ($u->super ?: (($u->permissions & $permissions)));
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
        "manage_site" => P_MANAGE_SITE,
        "view_attractions" => P_VIEW_ATTRACTION,
        "manage_attractions" => P_MANAGE_ATTRACTION,
        "view_users" => P_VIEW_USER,
        "manage_users" => P_MANAGE_USER,
    ];
}

function getUserPermissionsHashes(User $u): array
{
    $hashes = [];
    foreach (getPermissionsHash() as $k => $v) {
        if (check($u, $v, false)) {
            $hashes[] = $k;
        }
    }

    return $hashes;
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
