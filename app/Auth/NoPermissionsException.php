<?php

namespace App\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NoPermissionsException extends \Exception
{
    private const FORMAT = "The user `%d` has not the `%s` permission.";

    public function __construct(User $u, int $permissions)
    {
        parent::__construct(sprintf(self::FORMAT, $u->name, getPermissionKey($permissions)));
    }
}
