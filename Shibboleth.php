<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class Shibboleth
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!auth()->check()) {
            // If on local environment use .env value to mock server variable
            if (app()->environment() == 'local') $unity_id = env('APP_USER');
            // Read the server variables
            $identifiers = preg_grep('/^(.+)?SHIB_UID$/', array_keys($request->server()));
            if (count($identifiers)) $unity_id = $identifiers[0];
            // Redirect if no APP_USER or server variable
            if (!isset($unity_id)) return redirect('/login');
            $user = User::whereUnityId($unity_id)->first();
            // Abort with unauthorized error if user doesn't exist
            abort_if(is_null($user), 401);
            auth()->login($user);
        }
        return $next($request);
    }

}
