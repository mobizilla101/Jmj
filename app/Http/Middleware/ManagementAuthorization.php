<?php

namespace App\Http\Middleware;

use App\Enum\UserType;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ManagementAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        // Check if the user is of type 'management'
        if ($user->user_type !== UserType::MANAGEMENT && $user->user_type !== UserType::ADMIN) {
            abort(403, 'Access denied. This section is for management users only.');
        }

        return $next($request);
    }
}
