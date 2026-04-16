<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // If user is not logged in, redirect to login page
        if (!Auth::check()) {
            return redirect('/login'); // make sure /login route shows the login form
        }

        // If user is logged in but not admin, redirect to login (instead of 403)
        if ((int) Auth::user()->user_type !== 1) {
            Auth::logout(); // optional: log out non-admin user
            return redirect('/login'); // send them to login
        }

        // If admin, allow access
        return $next($request);
    }
}