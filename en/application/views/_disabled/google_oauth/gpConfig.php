<?php
session_start();
//Include Google client library 
include_once 'src/Google_Client.php';
include_once 'src/contrib/Google_Oauth2Service.php';

/*
 * Configuration and setup Google API
 */
$clientId = '123515224621-r29edfj1vr2n8k0dptmpf2gdsa13dbah.apps.googleusercontent.com'; //Google client ID
$clientSecret = 'olcJgVcX3NF7b9GALQr3b46v'; //Google client secret
$redirectURL = base_url().'login/googleoauth'; //Callback URL
$redirectURL = str_replace("http://", "https://", $redirectURL);


$clientId = "353601870016-48gv97ldi3m2p2vap4kfsjveboaj6vut.apps.googleusercontent.com";
$clientSecret	 = "HV-QcFNKRapbrPdeR2pdJ0EZ";

//Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('Login to CodexWorld.com');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectURL);

$google_oauthV2 = new Google_Oauth2Service($gClient);
?>