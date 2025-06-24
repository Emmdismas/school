<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class UserHelper
{
    public static function getLoggedInUser()
    {
        $guards = ['web', 'teacher', 'headmaster', 'accountant', 'student'];
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return Auth::guard($guard)->user();
            }
        }
        return null;
    }
    public static function getLoggedInUserSchoolId()
    {
        $user = self::getLoggedInUser();
        return $user ? $user->school_id : null;
    }
}
