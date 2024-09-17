<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider as UserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Support\Facades\Log;
use App\Helpers\AuditLogActivity;

class CustomUserProvider extends UserProvider {

    public function validateCredentials(UserContract $user, array $credentials)
    {
        $plain = $credentials['password'];
        
        // Database Authentication
        return $this->hasher->check($plain, $user->getAuthPassword());
    }

}