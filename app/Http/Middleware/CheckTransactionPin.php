<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckTransactionPin
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->transaction_pin === null) {

            // set flag agar modal muncul
            session()->put('must_set_pin', true);
        }

        return $next($request);
    }
}
