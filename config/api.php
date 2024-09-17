<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API ECOMMERCE CLIENT ID
    |--------------------------------------------------------------------------
    |
    | Client ID & Client Secret specific for each environments
    |
    */

    'api_ecom_pay_client_id' => env('API_ECOM_PAY_CLIENT_ID', null),

    'api_ecom_pay_client_secret' => env('API_ECOM_PAY_CLIENT_SECRET', null),

    //'api_ecom_client_secret' => $crypt->decrypt(env('api_ecom_client_secret', null)),


    /*
    |--------------------------------------------------------------------------
    | Grant Type
    |--------------------------------------------------------------------------
    |
    | The grant type used for authentication
    |
    */

    'api_ecom_pay_grant_type' => env('API_ECOM_PAY_GRANT_TYPE', null),


    /*
    |--------------------------------------------------------------------------
    | URL
    |--------------------------------------------------------------------------
    |
    | The Auth & Base URL for specific for each environments
    |
    */

    'api_ecom_pay_auth_url' => env('API_ECOM_PAY_AUTH_URL', null),

    'api_ecom_pay_base_url' => env('API_ECOM_PAY_BASE_URL', null),


    /*
    |--------------------------------------------------------------------------
    | Token Expiry Time
    |--------------------------------------------------------------------------
    |
    | Number of seconds where token will be valid
    |
    */

    'api_ecom_token_expiry_seconds' => env('api_ecom_pay_token_expiry_seconds', 250),




        /*
    |--------------------------------------------------------------------------
    | API EMAIL CLIENT ID
    |--------------------------------------------------------------------------
    |
    | Client ID & Client Secret specific for each environments
    |
    */

    'api_email_client_id' => env('API_EMAIL_CLIENT_ID', null),

    'api_email_client_secret' => env('API_EMAIL_CLIENT_SECRET', null),


    /*
    |--------------------------------------------------------------------------
    | API EMAIL Grant Type
    |--------------------------------------------------------------------------
    |
    | The grant type used for authentication
    |
    */

    'api_email_grant_type' => env('API_EMAIL_GRANT_TYPE', null),


    /*
    |--------------------------------------------------------------------------
    | API EMAIL URL
    |--------------------------------------------------------------------------
    |
    | The Auth & Base URL for specific for each environments
    |
    */

    'api_email_auth_url' => env('API_EMAIL_AUTH_URL', null),

    'api_email_base_url' => env('API_EMAIL_BASE_URL', null),


    /*
    |--------------------------------------------------------------------------
    | MAIL BOX
    |--------------------------------------------------------------------------
    |
    | The Auth & Base URL for specific for each environments
    |
    */

    'api_email_mailbox' => env('API_EMAIL_MAILBOX', null),

    'api_email_folderid' => env('API_EMAIL_FOLDERID', null),


    /*
    |--------------------------------------------------------------------------
    | API EMAIL Token Expiry Time
    |--------------------------------------------------------------------------
    |
    | Number of seconds where token will be valid
    |
    */

    'api_email_token_expiry_seconds' => env('api_email_token_expiry_seconds', 250),


    /*
    |--------------------------------------------------------------------------
    | API COCKPIT CLIENT ID
    |--------------------------------------------------------------------------
    |
    | Client ID & Client Secret specific for each environments
    |
    */

    'api_cockpit_client_id' => env('API_COCKPIT_CLIENT_ID', null),

    'api_cockpit_client_secret' => env('API_COCKPIT_CLIENT_SECRET', null),

    'api_cockpit_uat_client_id' => env('API_COCKPIT_UAT_CLIENT_ID', null),

    'api_cockpit_uat_client_secret' => env('API_COCKPIT_UAT_CLIENT_SECRET', null),


    /*
    |--------------------------------------------------------------------------
    | API COCKPIT Grant Type
    |--------------------------------------------------------------------------
    |
    | The grant type used for authentication
    |
    */

    'api_cockpit_grant_type' => env('API_COCKPIT_GRANT_TYPE', null),

    'api_cockpit_uat_grant_type' => env('API_COCKPIT_UAT_GRANT_TYPE', null),


    /*
    |--------------------------------------------------------------------------
    | API COCKPIT URL
    |--------------------------------------------------------------------------
    |
    | The Auth & Base URL for specific for each environments
    |
    */

    'api_cockpit_auth_url' => env('API_COCKPIT_AUTH_URL', null),

    'api_cockpit_base_url' => env('API_COCKPIT_BASE_URL', null),

    'api_cockpit_uat_auth_url' => env('API_COCKPIT_UAT_AUTH_URL', null),

    'api_cockpit_uat_base_url' => env('API_COCKPIT_UAT_BASE_URL', null),


    /*
    |--------------------------------------------------------------------------
    | API COCKPIT Token Expiry Time
    |--------------------------------------------------------------------------
    |
    | Number of seconds where token will be valid
    |
    */

    'api_cockpit_token_expiry_seconds' => env('api_cockpit_token_expiry_seconds', 250),

    'api_cockpit_uat_token_expiry_seconds' => env('api_cockpit_uat_token_expiry_seconds', 250),


    /*
    |--------------------------------------------------------------------------
    | API TRANSCODIFICATION CLIENT ID
    |--------------------------------------------------------------------------
    |
    | Client ID & Client Secret specific for each environments
    |
    */

    'api_transcodification_client_id' => env('API_TRANSCODIFICATION_CLIENT_ID', null),

    'api_transcodification_client_secret' => env('API_TRANSCODIFICATION_CLIENT_SECRET', null),

    'api_transcodification_uat_client_id' => env('API_TRANSCODIFICATION_UAT_CLIENT_ID', null),

    'api_transcodification_uat_client_secret' => env('API_TRANSCODIFICATION_UAT_CLIENT_SECRET', null),


    /*
    |--------------------------------------------------------------------------
    | API TRANSCODIFICATION Grant Type
    |--------------------------------------------------------------------------
    |
    | The grant type used for authentication
    |
    */

    'api_transcodification_grant_type' => env('API_TRANSCODIFICATION_GRANT_TYPE', null),

    'api_transcodification_uat_grant_type' => env('API_TRANSCODIFICATION_UAT_GRANT_TYPE', null),


    /*
    |--------------------------------------------------------------------------
    | API TRANSCODIFICATION URL
    |--------------------------------------------------------------------------
    |
    | The Auth & Base URL for specific for each environments
    |
    */

    'api_transcodification_auth_url' => env('API_TRANSCODIFICATION_AUTH_URL', null),

    'api_transcodification_base_url' => env('API_TRANSCODIFICATION_BASE_URL', null),

    'api_transcodification_uat_auth_url' => env('API_TRANSCODIFICATION_UAT_AUTH_URL', null),

    'api_transcodification_uat_base_url' => env('API_TRANSCODIFICATION_UAT_BASE_URL', null),


    /*
    |--------------------------------------------------------------------------
    | API TRANSCODIFICATION Token Expiry Time
    |--------------------------------------------------------------------------
    |
    | Number of seconds where token will be valid
    |
    */

    'api_token_expiry_seconds' => env('api_token_expiry_seconds', 250),

    'api_token_uat_expiry_seconds' => env('api_token_uat_expiry_seconds', 250),


];
