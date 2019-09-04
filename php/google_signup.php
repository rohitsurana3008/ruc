<?php

require 'setup.php';
session_start();
// Create a new Google API client
$client = new apiClient();
//$client->setApplicationName("Tutorialzine");

// Configure it
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setDeveloperKey($api_key);
$client->setRedirectUri($redirect_url);
$client->setApprovalPrompt(false);
$oauth2 = new apiOauth2Service($client);


// The code parameter signifies that this is
// a redirect from google, bearing a temporary code


if (isset($_GET['code'])) {
	
	// This method will obtain the actuall access token from Google,
	// so we can request user info
	$client->authenticate();
	
	// Get the user data
	$info = $oauth2->userinfo->get();
	
	// Find this person in the database
	$person = ORM::for_table('users')->where('email', $info['email'])->find_one();
	
	if(!$person){
		// No such person was found. Register!
	    
	    if(!isset($_SESSION['user_info'])){
	        $_SESSION['user_info'] = $info;
        }
	    
		header("Location: $redirect_url_codeverify");
	}else{
	
	// Save the user id to the session
	$_SESSION['user_id'] = $person->id();
	$_SESSION['user_name'] = $person->user_name;
	$_SESSION['user_email'] = $person->email;
	$_SESSION['user_photo'] = $person->photo;

	// Redirect to the base demo URL
	header("Location: $redirect_url_home");
	}
	exit;
}

// Handle logout
if (isset($_GET['logout'])) {
	unset($_SESSION['user_id']);
	unset($_SESSION['user_name']);
	unset($_SESSION['user_email']);
	unset($_SESSION['user_photo']);
}

$person = null;
if(isset($_SESSION['user_id'])){
	// Fetch the person from the database
	$person = ORM::for_table('users')->find_one($_SESSION['user_id']);
}

?>