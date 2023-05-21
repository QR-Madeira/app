<?php

namespace App\Auth;

use App\Models\User;

class NoPermissionsException extends \Exception
{
    private const FORMAT = "The user `%s` has not the `%s` permission.";

    public function __construct(User $u, int $permissions)
    {
        parent::__construct(sprintf(self::FORMAT, $u->email, getPermissionKey($permissions)));
    }
}
