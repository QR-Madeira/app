<?php

namespace App\Auth;

use Illuminate\Support\Facades\Auth;

class NoPermissionsException extends \Exception
{
    private const FORMAT = "The user `%d` has not the `%s` permission.";

    public function __construct(int $permissions)
    {
        parent::__construct(sprintf(self::FORMAT, Auth::getName(), getPermissionKey($permissions)));
    }
}
