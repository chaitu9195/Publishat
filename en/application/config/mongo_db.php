<?php
$config['mongo_db']['active'] = 'newdb';
$config['mongo_db']['newdb']['hostname'] = 'localhost';
$config['mongo_db']['newdb']['port'] = '27017';
$config['mongo_db']['newdb']['username'] = 'publisha_dbase';
$config['mongo_db']['newdb']['password'] = 'ViJaYa@#321';
$config['mongo_db']['newdb']['database'] = 'publisha_dbase';
// Local dev MongoDB runs without authentication (see C:\mongodb). The app
// otherwise builds a credentialed URI, which fails against a no-auth server.
// Set to FALSE (and provide username/password above) when connecting to an
// auth-enabled production MongoDB.
$config['mongo_db']['newdb']['no_auth'] = true;
$config['mongo_db']['newdb']['db_debug'] = true;
$config['mongo_db']['newdb']['write_concerns'] = (int) 1;
$config['mongo_db']['newdb']['journal'] = true;
$config['mongo_db']['newdb']['read_preference'] = null;
$config['mongo_db']['newdb']['read_preference_tags'] = null;

?>
