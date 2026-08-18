<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
class PlatformAdmin { public function handle(Request $request, Closure $next) { abort_unless($request->user()?->platform_admin, 403); return $next($request); } }
