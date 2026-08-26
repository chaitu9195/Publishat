<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use Google\Client as GoogleClient;

if (!defined('GOOGLE_OAUTH_CLIENT_ID')) {
    define('GOOGLE_OAUTH_CLIENT_ID', '353601870016-48gv97ldi3m2p2vap4kfsjveboaj6vut.apps.googleusercontent.com');
    define('GOOGLE_OAUTH_CLIENT_SECRET', 'HV-QcFNKRapbrPdeR2pdJ0EZ');
}

if (!function_exists('google_oauth_client')) {
    function google_oauth_client()
    {
        $client = new GoogleClient();
        $client->setApplicationName('Login to publishat.com');
        $client->setClientId(GOOGLE_OAUTH_CLIENT_ID);
        $client->setClientSecret(GOOGLE_OAUTH_CLIENT_SECRET);

        $client->setRedirectUri(base_url() . 'login/googleoauth');

        $client->addScope('email');
        $client->addScope('profile');
        $client->setAccessType('online');

        return $client;
    }
}

if (!function_exists('google_login_url')) {
    function google_login_url()
    {
        return google_oauth_client()->createAuthUrl();
    }
}
