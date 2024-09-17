<?php

namespace App\Http\Middleware;

use Illuminate\Support\Str;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Helpers\SecretManagerHelper;

class SecretManager
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
        SecretManagerHelper::setDatabaseConnectionDetails(true);
        SecretManagerHelper::setLaraDatabaseConnectionDetails(true);
        SecretManagerHelper::setCmaApiOauthCredentials(true);

        return $next($request);
    }
}
