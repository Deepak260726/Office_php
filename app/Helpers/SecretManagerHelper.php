<?php

namespace App\Helpers;

use Aws\SecretsManager\SecretsManagerClient;
use Aws\Exception\AwsException;
use App\Infrastructure\Constants\CacheConstant;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class SecretManagerHelper
{


    /**
     * Get Secret from the Cloud Sore (AWS Secret Manager)
     *
     * @param  string secret_id, boolean use_cache, string cache_key, int cache_ttl_in_seconds, string cache_target
     * @return string|null secret
     */
    public static function getSecretFromStore($secret_id, $use_cache = true, $cache_key = null, $cache_ttl_in_seconds = CacheConstant::CACHE_DURATION_24_HOURS_IN_SECONDS)
    {
        $cache_target = (config('app.deploy_target') == 'cloud') ? CacheConstant::CACHE_TARGET_APCU : CacheConstant::CACHE_TARGET_REDIS;
        $secret = null;

        if($use_cache && $cache_key != null) {
            $start = microtime(TRUE);

            if($cache_target == CacheConstant::CACHE_TARGET_REDIS) {
                $secret = Cache::get($cache_key);
            }else if($cache_target == CacheConstant::CACHE_TARGET_APCU) {
                $secret = SecretManagerHelper::getCacheDataFromApcu($cache_key);
            }

            $end = microtime(TRUE);

            if($secret != null) {
                if(env('APP_ENV') != 'production') {
                    Log::debug("Retreived secret from Cache - Time Taken - " . $secret_id . " - " . (number_format($end - $start , 5)));
                }

                $secret = ($cache_target != CacheConstant::CACHE_TARGET_APCU) ? Crypt::decryptString($secret) : $secret;
            }
        }

        if($secret == null) {
            Log::debug("Getting secret from AWS Secret Manager - " . $secret_id);

            $start = microtime(TRUE);

            $client = new SecretsManagerClient([
                'version' => 'latest',
                'region' => 'ap-southeast-1'
            ]);

            $result = $client->getSecretValue([
                'SecretId' => $secret_id,
            ]);

            $end = microtime(TRUE);
            Log::debug("Retreived secret from AWS Secret Manager - Time Taken - " . $secret_id . " - " . (number_format($end - $start , 4)));

            // Decrypts secret using the associated KMS CMK.
            // Depending on whether the secret is a string or binary, one of these fields will be populated.
            if (isset($result['SecretString'])) {
                $secret = $result['SecretString'];
            } else if (isset($result['SecretBinary'])) {
                $secret = base64_decode($result['SecretBinary']);
            } else {
                $secret = null;
            }

            if($cache_key != null && $cache_target != CacheConstant::CACHE_TARGET_APCU) {
                Cache::put($cache_key, Crypt::encryptString($secret), $cache_ttl_in_seconds);
                Log::debug("Secret cached - " . $secret_id);
            }else if ($cache_key != null && $cache_target == CacheConstant::CACHE_TARGET_APCU) {
                SecretManagerHelper::setCacheDataInApcu($cache_key, $secret, $cache_ttl_in_seconds);
            }
        }

        if($secret == null) {
            throw new \Exception("SecretManagerHelper@getSecretFromStore - Unable to retreive the secret from the store - " . $secret_id);
        }

        if (env('APP_ENV') == 'local' && $cache_target != CacheConstant::CACHE_TARGET_APCU) {
            Log::debug("SecretManagerHelper@getSecretFromStore - " . $secret_id . " - " . $secret);
        }

        return $secret;
    }

    /**
     * Set Redis Credentials
     *
     * @param  boolean
     * @return array
     */
    public static function setRedisCredentials($use_cache = true)
    {
        $config = array();


            $config = [
                'scheme' => env('REDIS_SCHEME', 'tcp'),
                'host' => env('REDIS_HOST', '127.0.0.1'),
                'password' => env('REDIS_PASSWORD', null),
                'port' => env('REDIS_PORT', 6379),
                'database' => 0,
                'read_timeout' => 10,
            ];

            config(['database.redis.default' => $config]);


        return $config;
    }


    /**
     * Set MySQL Database connection parameter
     *
     * @param  use_cache
     * @return
     */
    public static function setDatabaseConnectionDetails($use_cache = true)
    {
        if (!SecretManagerHelper::isAwsSecretManagerActive()) {
            config(['database.connections.mysql' => [
                'driver' => 'mysql',
                'host' => env('DB_HOST'),
                'port' => env('DB_PORT'),
                'database' => env('DB_DATABASE'),
                'username' => env('DB_USERNAME'),
                'password' => env('DB_PASSWORD'),
                'unix_socket' => env('DB_SOCKET'),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'strict' => false,
                'engine' => null,
            ]]);

            return;
        }

        $cache_key = CacheConstant::CACHE_KEY_DATABASE_MYSQL;
        $secret_key = env('DB_SECRET_KEY');

        $secret_json = SecretManagerHelper::getSecretFromStore($secret_key, $use_cache, $cache_key);

        $secret_object = json_decode($secret_json);

        config(['database.connections.mysql' => [
            'driver' => 'mysql',
            'host' => $secret_object->host,
            'port' => $secret_object->port,
            'database' => $secret_object->dbname,
            'username' => $secret_object->username,
            'password' => $secret_object->password,
            'unix_socket' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ]]);

        return;
    }

    /**
     * Set LARA Database connection parameter
     *
     * @param  use_cache
     * @return
     */
    public static function setLaraDatabaseConnectionDetails($use_cache = true)
    {
        if (!SecretManagerHelper::isAwsSecretManagerActive()) {
            config(['oracle.aral' => [
                'driver'         => 'oracle',
                'host'           => env('ARAL_DB_HOST'),
                'port'           => env('ARAL_DB_PORT'),
                'database'       => env('ARAL_DB_DATABASE'),
                'service_name'   => env('ARAL_DB_SERVICE_NAME'),
                'username'       => env('ARAL_DB_USERNAME'),
                'password'       => env('ARAL_DB_PASSWORD'),
                'charset'        => env('ARAL_DB_CHARSET'),
                'prefix'         => env('ARAL_DB_PREFIX'),
                'prefix_schema'  => env('ARAL_DB_SCHEMA_PREFIX'),
                'edition'        => env('ARAL_DB_EDITION'),
                'server_version' => env('ARAL_DB_SERVER_VERSION'),
            ]]);

            config(['database.connections.aral' => [
                'driver'         => 'oracle',
                'host'           => env('ARAL_DB_HOST'),
                'port'           => env('ARAL_DB_PORT'),
                'database'       => env('ARAL_DB_DATABASE'),
                'service_name'   => env('ARAL_DB_SERVICE_NAME'),
                'username'       => env('ARAL_DB_USERNAME'),
                'password'       => env('ARAL_DB_PASSWORD'),
                'charset'        => env('ARAL_DB_CHARSET'),
                'prefix'         => env('ARAL_DB_PREFIX'),
                'prefix_schema'  => env('ARAL_DB_SCHEMA_PREFIX'),
                'edition'        => env('ARAL_DB_EDITION'),
                'server_version' => env('ARAL_DB_SERVER_VERSION'),
            ]]);

            return;
        }

        $cache_key = CacheConstant::CACHE_KEY_DATABASE_ARAL;
        $secret_key = env('ARAL_DB_SECRET_KEY');

        $secret_json = SecretManagerHelper::getSecretFromStore($secret_key, $use_cache, $cache_key);

        $secret_object = json_decode($secret_json);

        config(['oracle.aral' => [
            'driver' => 'oracle',
            'host' => $secret_object->host,
            'port'           => $secret_object->port,
            'database'       => env('ARAL_DB_DATABASE'),
            'service_name'   => $secret_object->service_name,
            'username'       => $secret_object->username,
            'password'       => $secret_object->password,
            'charset'        => env('ARAL_DB_CHARSET'),
            'prefix'         => env('ARAL_DB_PREFIX'),
            'prefix_schema'  => env('ARAL_DB_SCHEMA_PREFIX'),
            'edition'        => env('ARAL_DB_EDITION'),
            'server_version' => env('ARAL_DB_SERVER_VERSION'),
        ]]);

        config(['database.connections.aral' => [
            'driver' => 'oracle',
            'host' => $secret_object->host,
            'port'           => $secret_object->port,
            'database'       => env('ARAL_DB_DATABASE'),
            'service_name'   => $secret_object->service_name,
            'username'       => $secret_object->username,
            'password'       => $secret_object->password,
            'charset'        => env('ARAL_DB_CHARSET'),
            'prefix'         => env('ARAL_DB_PREFIX'),
            'prefix_schema'  => env('ARAL_DB_SCHEMA_PREFIX'),
            'edition'        => env('ARAL_DB_EDITION'),
            'server_version' => env('ARAL_DB_SERVER_VERSION'),
        ]]);

        return;
    }

    /**
     * Set CMA API OAuth Credentials
     *
     * @param  use_cache
     * @return
     */
    public static function setCmaApiOauthCredentials($use_cache = true)
    {
        if (SecretManagerHelper::isAwsSecretManagerActive()) {

            //ECOM_PAY_CLIENT
            $ecom_cache_key = CacheConstant::CACHE_KEY_CMA_ECOM_API_OAUTH;
            $ecom_pay_secret_key = env('API_ECOM_PAY_SECRET_KEY');
            $ecom_pay_secret_object = SecretManagerHelper::getCmaApiOauthCredentials($ecom_pay_secret_key, $ecom_cache_key);

            config(['api.api_ecom_pay_client_id' => $ecom_pay_secret_object->client_id]);
            config(['api.api_ecom_pay_client_secret' => $ecom_pay_secret_object->client_secret]);
            config(['api.api_ecom_pay_grant_type' => $ecom_pay_secret_object->grant_type]);

            //EMAIL API Client
            $email_cache_key = CacheConstant::CACHE_KEY_CMA_EMAIL_API_OAUTH;
            $email_secret_key = env('API_EMAIL_SECRET_KEY');
            $email_secret_object = SecretManagerHelper::getCmaApiOauthCredentials($email_secret_key, $email_cache_key);

            config(['api.api_email_client_id' => $email_secret_object->client_id]);
            config(['api.api_email_client_secret' => $email_secret_object->client_secret]);
            config(['api.api_email_grant_type' => $email_secret_object->grant_type]);

            //COCKPIT API - PRD
            $cockpit_cache_key = CacheConstant::CACHE_KEY_CMA_COCKPIT_API_OAUTH;
            $cockpit_pay_secret_key = env('API_COCKPIT_SECRET_KEY');
            $cockpit_pay_secret_object = SecretManagerHelper::getCmaApiOauthCredentials($cockpit_pay_secret_key, $cockpit_cache_key);

            config(['api.api_cockpit_client_id' => $cockpit_pay_secret_object->client_id]);
            config(['api.api_cockpit_client_secret' => $cockpit_pay_secret_object->client_secret]);
            config(['api.api_cockpit_grant_type' => $cockpit_pay_secret_object->grant_type]);

            //COCKPIT API - UAT
            $cockpit_uat_cache_key = CacheConstant::CACHE_KEY_CMA_COCKPIT_UAT_API_OAUTH;
            $cockpit_uat_secret_key = env('API_COCKPIT_UAT_SECRET_KEY');
            $cockpit_uat_secret_object = SecretManagerHelper::getCmaApiOauthCredentials($cockpit_uat_secret_key, $cockpit_uat_cache_key);

            config(['api.api_cockpit_uat_client_id' => $cockpit_uat_secret_object->client_id]);
            config(['api.api_cockpit_uat_client_secret' => $cockpit_uat_secret_object->client_secret]);
            config(['api.api_cockpit_uat_grant_type' => $cockpit_uat_secret_object->grant_type]);

            //TRANSCODIFICATION API Client - PRD
            $transco_cache_key = CacheConstant::CACHE_KEY_CMA_TRANSCO_API_OAUTH;
            $transco_secret_key = env('API_TRANSCODIFICATION_SECRET_KEY');
            $transco_secret_object = SecretManagerHelper::getCmaApiOauthCredentials($transco_secret_key, $transco_cache_key);

            config(['api.api_transcodification_client_id' => $transco_secret_object->client_id]);
            config(['api.api_transcodification_client_secret' => $transco_secret_object->client_secret]);
            config(['api.api_transcodification_grant_type' => $transco_secret_object->grant_type]);

            //TRANSCODIFICATION API Client - UAT
            $transco_uat_cache_key = CacheConstant::CACHE_KEY_CMA_TRANSCO_UAT_API_OAUTH;
            $transco_uat_secret_key = env('API_TRANSCODIFICATION_UAT_SECRET_KEY');
            $transco_uat_secret_object = SecretManagerHelper::getCmaApiOauthCredentials($transco_uat_secret_key, $transco_uat_cache_key);

            config(['api.api_transcodification_uat_client_id' => $transco_uat_secret_object->client_id]);
            config(['api.api_transcodification_uat_client_secret' => $transco_uat_secret_object->client_secret]);
            config(['api.api_transcodification_uat_grant_type' => $transco_uat_secret_object->grant_type]);

        } else {

            //ECOM_PAY_CLIENT
            config(['api.api_ecom_pay_client_id' => env('API_ECOM_PAY_CLIENT_ID')]);
            config(['api.api_ecom_pay_client_secret' => env('API_ECOM_PAY_CLIENT_SECRET')]);
            config(['api.api_ecom_pay_grant_type' => env('API_ECOM_PAY_GRANT_TYPE')]);

            //EMAIL API Client
            config(['api.api_email_client_id' => env('API_EMAIL_CLIENT_ID')]);
            config(['api.api_email_client_secret' => env('API_EMAIL_CLIENT_SECRET')]);
            config(['api.api_email_grant_type' => env('API_EMAIL_GRANT_TYPE')]);

            //COCKPIT API - PRD
            config(['api.api_cockpit_client_id' => env('API_COCKPIT_CLIENT_ID')]);
            config(['api.api_cockpit_client_secret' => env('API_COCKPIT_CLIENT_SECRET')]);
            config(['api.api_cockpit_grant_type' => env('API_COCKPIT_GRANT_TYPE')]);

            //COCKPIT API - UAT
            config(['api.api_cockpit_uat_client_id' => env('API_COCKPIT_UAT_CLIENT_ID')]);
            config(['api.api_cockpit_uat_client_secret' => env('API_COCKPIT_UAT_CLIENT_SECRET')]);
            config(['api.api_cockpit_uat_grant_type' => env('API_COCKPIT_UAT_GRANT_TYPE')]);

            //TRANSCODIFICATION API Client - PRD
            config(['api.api_transcodification_client_id' => env('API_TRANSCODIFICATION_CLIENT_ID')]);
            config(['api.api_transcodification_client_secret' => env('API_TRANSCODIFICATION_CLIENT_SECRET')]);
            config(['api.api_transcodification_grant_type' => env('API_TRANSCODIFICATION_GRANT_TYPE')]);

            //TRANSCODIFICATION API Client - UAT
            config(['api.api_transcodification_uat_client_id' => env('API_TRANSCODIFICATION_UAT_CLIENT_ID')]);
            config(['api.api_transcodification_uat_client_secret' => env('API_TRANSCODIFICATION_UAT_CLIENT_SECRET')]);
            config(['api.api_transcodification_uat_grant_type' => env('API_TRANSCODIFICATION_UAT_GRANT_TYPE')]);

        }

        return;
    }


    /**
     * Get CMA API OAuth Credentials
     *
     * @param  use_cache
     * @return
     */
    public static function getCmaApiOauthCredentials($secret_key, $cache_key,  $use_cache = true)
    {
        $secret_json = SecretManagerHelper::getSecretFromStore($secret_key, $use_cache, $cache_key);

        $secret_object = json_decode($secret_json);

        return $secret_object;
    }

    /**
     * Check if AWS Secret Manager active
     *
     * @param
     * @return bool
     */
    public static function isAwsSecretManagerActive() {
        if (env('APP_ENV') == 'local' || config('app.deploy_target') != 'cloud') {
            return false;
        }else {
            return true;
        }
    }


    /**
     * Retreive Cached Data from APCu
     *
     * @param string
     * @return string
     */
    public static function getCacheDataFromApcu($key) {
        $data = false;

        if(function_exists('apcu_cache_info')) {
            $data = \apcu_fetch($key);
        }

        return $data ?? null;
    }


    /**
     * Set Cached Data in APCu
     *
     * @param string, string, integer
     * @return bool
     */
    public static function setCacheDataInApcu($key, $data, $cache_ttl_in_seconds) {
        if(function_exists('apcu_cache_info')) {
            \apcu_add($key, $data, $cache_ttl_in_seconds);
        }

        return;
    }

    /**
     * Clear all existing secrets Cache
     *
     * @param
     * @return
     */
    public static function clearSecretsCache() {
        try {
            // REDIS Cache
            Cache::forget(CacheConstant::CACHE_KEY_CMA_ECOM_API_OAUTH);
            Cache::forget(CacheConstant::CACHE_KEY_CMA_EMAIL_API_OAUTH);
            Cache::forget(CacheConstant::CACHE_KEY_DATABASE_ARAL);
            Cache::forget(CacheConstant::CACHE_KEY_DATABASE_MYSQL);
            Cache::forget(CacheConstant::CACHE_KEY_CMA_COCKPIT_API_OAUTH);
            Cache::forget(CacheConstant::CACHE_KEY_CMA_TRANSCO_API_OAUTH);
            Cache::forget(CacheConstant::CACHE_KEY_CMA_COCKPIT_UAT_API_OAUTH);
            Cache::forget(CacheConstant::CACHE_KEY_CMA_TRANSCO_UAT_API_OAUTH);

            // APCu
            if(function_exists('apcu_cache_info')) {
                \apcu_delete(CacheConstant::CACHE_KEY_CMA_ECOM_API_OAUTH);
                \apcu_delete(CacheConstant::CACHE_KEY_CMA_EMAIL_API_OAUTH);
                \apcu_delete(CacheConstant::CACHE_KEY_CMA_COCKPIT_API_OAUTH);
                \apcu_delete(CacheConstant::CACHE_KEY_CMA_TRANSCO_API_OAUTH);
                \apcu_delete(CacheConstant::CACHE_KEY_CMA_COCKPIT_UAT_API_OAUTH);
                \apcu_delete(CacheConstant::CACHE_KEY_CMA_TRANSCO_UAT_API_OAUTH);
                \apcu_delete(CacheConstant::CACHE_KEY_DATABASE_ARAL);
                \apcu_delete(CacheConstant::CACHE_KEY_DATABASE_MYSQL);
                \apcu_delete(CacheConstant::CACHE_KEY_REDIS);
                \apcu_clear_cache();
            }

            Log::info("Secret Cache Clearred - SecretManagerHelper@clearSecretsCache");

        }catch(Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
