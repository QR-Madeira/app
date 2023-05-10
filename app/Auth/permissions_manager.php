<?php

namespace App\Auth;

use App\Models\User;

const P_ZERO = 0x0;

const P_VIEW_ATTRACTION = 0x1 << 0;
const P_CREATE_ATTRACTION = 0x1 << 1;
const P_UPDATE_ATTRACTION = 0x1 << 2;
const P_DELETE_ATTRACTION = 0x1 << 3;
const P_ALL_ATTRACTION = P_VIEW_ATTRACTION
    | P_CREATE_ATTRACTION
    | P_UPDATE_ATTRACTION
    | P_DELETE_ATTRACTION;

const P_VIEW_USER = 0x1 << 4;
const P_CREATE_USER = 0x1 << 5;
const P_UPDATE_USER = 0x1 << 6;
const P_DELETE_USER = 0x1 << 7;
const P_ALL_USER = P_VIEW_USER
    | P_CREATE_USER
    | P_UPDATE_USER
    | P_DELETE_USER;

const P_ALL = P_ALL_ATTRACTION | P_ALL_USER;

function check(User $u, int $permissions): bool
{
    return ($u->permissions & $permissions) === $permissions;
}

function checkOrThrow(User $u, int $permissions): true
{
    if (!check($u, $permissions)) {
        throw new NoPermissionsException($permissions);
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

function getPermissionsHash(bool $extendo = false): array
{
    return $extendo ? [
        "no" => P_ZERO,
        "view_attractions" => P_VIEW_ATTRACTION,
        "create_attractions" => P_CREATE_ATTRACTION,
        "update_attractions" => P_UPDATE_ATTRACTION,
        "delete_attractions" => P_DELETE_ATTRACTION,
        "attractions" => P_ALL_ATTRACTION,
        "view_users" => P_VIEW_USER,
        "create_users" => P_CREATE_USER,
        "update_users" => P_UPDATE_USER,
        "delete_users" => P_DELETE_USER,
        "users" => P_ALL_USER,
        "all" => P_ALL,
    ] : [
        "no" => P_ZERO,
        "attractions" => P_ALL_ATTRACTION,
        "users" => P_ALL_USER,
        "all" => P_ALL,
    ];
}

function getPermissionKey(int $permission): ?string
{
    foreach (getPermissionsHash(true) as $k => $v) {
        if ($v === $permission) {
            return $k;
        }
    }

    return null;
}
