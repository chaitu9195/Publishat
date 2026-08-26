<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

use Google\Client as GoogleClient;

/**
 * Google OAuth helper — modern google/apiclient replacement for the retired
 * 2010-era bundled Google_Client library (formerly in views/google_oauth/).
 *
 * Credentials were previously hard-coded across gpConfig.php, Login.php and
 * Signup.php; they are centralised here. The active pair is the one the old
 * code actually used (the later assignments that overrode the earlier ones).
 */
if (!defined('GOOGLE_OAUTH_CLIENT_ID')) {
	define('GOOGLE_OAUTH_CLIENT_ID', '353601870016-48gv97ldi3m2p2vap4kfsjveboaj6vut.apps.googleusercontent.com');
	define('GOOGLE_OAUTH_CLIENT_SECRET', 'HV-QcFNKRapbrPdeR2pdJ0EZ');
}

if (!function_exists('google_oauth_client')) {
	/**
	 * Build a configured modern Google\Client.
	 *
	 * @return \Google\Client
	 */
	function google_oauth_client()
	{
		$client = new GoogleClient();
		$client->setApplicationName('Login to publishat.com');
		$client->setClientId(GOOGLE_OAUTH_CLIENT_ID);
		$client->setClientSecret(GOOGLE_OAUTH_CLIENT_SECRET);

		// Callback is always handled by Login::googleoauth_get (as registered
		// with Google). Uses base_url(), which is now dynamic per accessed host
		// (http://localhost/... locally, https://<prod-host>/... in production).
		$client->setRedirectUri(base_url() . 'login/googleoauth');

		$client->addScope('email');
		$client->addScope('profile');
		$client->setAccessType('online');

		return $client;
	}
}

if (!function_exists('google_login_url')) {
	/**
	 * The "Sign in with Google" URL used by the views (replaces the old
	 * $gClient->createAuthUrl() call).
	 *
	 * @return string
	 */
	function google_login_url()
	{
		return google_oauth_client()->createAuthUrl();
	}
}
