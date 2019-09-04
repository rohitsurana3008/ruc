<?php

// Includes

require_once 'includes/google-api-php-client/apiClient.php';
require_once 'includes/google-api-php-client/contrib/apiOauth2Service.php';
require_once 'includes/idiorm.php';
require_once 'includes/relativeTime.php';

// Session. Pass your own name if you wish.

// Database configuration with the IDIORM library

$host = 'rucdb.atown.dreamhosters.com';
$user = 'rucdbuser';
$pass = 'rucDB9ass';
$database = 'ruconncdb';

ORM::configure("mysql:host=$host;dbname=$database");
ORM::configure('username', $user);
ORM::configure('password', $pass);

// Changing the connection to unicode
ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

// Google API. Obtain these settings from https://code.google.com/apis/console/

$redirect_url = 'http://www.atown.dreamhosters.com/ruc/';
$redirect_url_home = 'http://www.atown.dreamhosters.com/ruc/home.php';
$redirect_url_codeverify = 'http://www.atown.dreamhosters.com/ruc/codeverify.php';
$client_id = '473863992657-rhsdoi0qg2ohjae2qoecptvobhu55o4v.apps.googleusercontent.com';
$client_secret = 'TUx9OhZqMS09NgyathxznBWH';
$api_key = 'AIzaSyDIjr80j5jO-LkklukgP-20bvmEgAJbYUw';

?>