<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Role; // Add this import statement
use App\Models\User; // Add this import statement

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!$request->user() || !$request->user()->roles()->whereIn('name', $roles)->exists()) {
            return redirect('login')->with('error', 'Je hebt geen toegangsrechten.');
        }

        return $next($request);
    }
}
