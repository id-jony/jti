<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ChangeLocale
{
    public const KEY = 'lang';

    public function handle(Request $request, Closure $next)
    {
        $local = $request->get(
            self::KEY,
            Session::get(self::KEY)
        );
        if ($local) {
            app()->setLocale($local);
            Session::put(self::KEY, $local);
        }
        return $next($request);
    }
}
