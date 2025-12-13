<?php

namespace App\Http\Middleware;

use Closure;

class CheckTransactionPin
{
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->transaction_pin === null) {
            session()->put('must_set_pin', true);
        }

        return $next($request);
    }

}

