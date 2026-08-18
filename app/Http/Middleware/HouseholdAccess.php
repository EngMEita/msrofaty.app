<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HouseholdAccess
{
    public function handle(Request $request, Closure $next)
    {
        $household = $request->user()?->household();
        abort_unless($household, 403, 'You are not a member of a household.');
        abort_if($household->status !== 'active', 403, 'This household is suspended.');
        $request->attributes->set('household', $household);
        return $next($request);
    }
}
