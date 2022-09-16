<?php

namespace Esyede;

defined('DS') or exit('No direct script access.');

use System\Auth;
use System\Config;
use System\Request;
use System\Session;
use System\Redirect;
use System\Database;

class Impersonate
{
    /**
     * Impersonate user.
     *
     * @param int $user_id
     *
     * @return \stdClass|null
     */
    public static function login($user_id)
    {
        if (! Auth::check()) {
            Session::forget('impersonate');
            return null;
        }

        $actor = Auth::user();
        $target = Database::table(Config::get('auth.table'))
            ->where('id', $user_id)
            ->first();

        if (! $target) {
            return null;
        }

        Session::put('impersonate', compact('actor', 'target'));
        Auth::login($target->id);

        return Auth::user();
    }

    /**
     * Hentikan impersonate user.
     *
     * @return \stdClass|null
     */
    public static function leave()
    {
        if (! Auth::check()) {
            Session::forget('impersonate');
            return null;
        }

        $actor = Session::get('impersonate.actor');

        if (! is_object($actor)) {
            return null;
        }

        Session::forget('impersonate');
        Auth::login($actor->id);

        return Auth::user();
    }
}
