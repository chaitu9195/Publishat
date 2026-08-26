<?php
             $google_client_id       = '912112255303-5ljvg74mkmnhaaq6qkvoefe2pb06dgs4.apps.googleusercontent.com';
             $google_client_secret 	= 'zbzbYMN6RiQSQacOBVJvGWGK';
             $google_redirect_url 	= 'https://publishat.com/restapp/en/login/googleoauth'; //path to your script
             $google_developer_key 	= '700321064212-m4p4ltakaf4v2112fqf59v1uoloolb5q@developer.gserviceaccount.com';

             require_once 'google_oauth/src/Google_Client.php';
             require_once 'google_oauth/src/contrib/Google_Oauth2Service.php';
             $gClient = new Google_Client();
             $gClient->setApplicationName('Login to publishat.com');
             $gClient->setClientId($google_client_id);
             $gClient->setClientSecret($google_client_secret);
             $gClient->setRedirectUri($google_redirect_url);
             $gClient->setDeveloperKey($google_developer_key);

             $google_oauthV2 = new Google_Oauth2Service($gClient);

              //If user wish to log out, we just unset Session variable
             if (isset($_REQUEST['reset'])) 
              {
                   unset($_SESSION['token']);
                   $gClient->revokeToken();
                       header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL)); //redirect user back to page
               }
               if (isset($_GET['code'])) 
               { 
	           $gClient->authenticate($_GET['code']);
	           $_SESSION['token'] = $gClient->getAccessToken();
	           header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
	           return;
               }
               if (isset($_SESSION['token'])) 
               { 
	           $gClient->setAccessToken($_SESSION['token']);
               }


              if ($gClient->getAccessToken()) 
              {
	        //For logged in user, get details from google using access token
	            $user 	     = $google_oauthV2->userinfo->get();
	            $user_id 	     = $user['id'];
	            $user_name 	     = filter_var($user['name'], FILTER_SANITIZE_SPECIAL_CHARS);
                    $gender            = filter_var($user['gender'], FILTER_SANITIZE_EMAIL);
                    $birthday          = filter_var($user['birthday'], FILTER_SANITIZE_EMAIL);
	            $email 	     = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
	            $profile_url 	     = filter_var($user['link'], FILTER_VALIDATE_URL);
	            $profile_image_url = filter_var($user['picture'], FILTER_VALIDATE_URL);
	            $personMarkup      = "$email<div><img src='$profile_image_url?sz=50'></div>";
	            $_SESSION['token'] = $gClient->getAccessToken();
             }
echo $user_name;
echo $user_id;
echo $gender;
echo $email;
