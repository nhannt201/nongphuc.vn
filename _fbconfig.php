<?php
session_start();
// added in v4.0.0
require_once 'autoload.php';
require_once './inl/DB.php';	
$user = new DB();
//require 'functions.php';
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
//use Facebook\Entities\AccessToken;
/*use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;*/
// init app with App id and Secret
FacebookSession::setDefaultApplication( $user->GetAppID("facebook"),$user->GetAppSecret("facebook") );
// login helper with redirect_uri
    $helper = new FacebookRedirectLoginHelper($domain_home.'login-facebook.html' );
try {
      $session = $helper->getSessionFromRedirect();
   }catch( FacebookRequestException $ex ) {
      // When Facebook returns an error
   }catch( Exception $ex ) {
      // When validation fails or other local issues
   }
   
   // see if we have a session
   if ( isset( $session ) ) {
	   // User logged in, get the AccessToken entity.
		$accessToken = $session->getAccessToken();
		//echo $accessToken;
		//exit;
		//$longLivedAccessToken = $accessToken->extend();
      // graph api request for user data
      $request = new FacebookRequest( $session, 'GET', '/me' );
      $response = $request->execute();
      
      // get response
      $graphObject = $response->getGraphObject();
      $fbid = $graphObject->getProperty('id');           // To Get Facebook ID
      $fbfullname = $graphObject->getProperty('name');   // To Get Facebook full name
      $femail = $graphObject->getProperty('email');      // To Get Facebook email ID
      
      /* ---- Session Variables -----*/
      $_SESSION['FBID'] = $fbid;
      $_SESSION['FULLNAME'] = $fbfullname;
    //  $_SESSION['EMAIL'] =  $femail;
	  if (strlen($femail) > 1) {}
	  //Initialize DB class and add
		
         if (($user->fbCheck($fbid,$fbfullname))) {
				header("Location: ".$domain_home);
		 } else {
			 if (isset($_SESSION['LOG'])) {
				$user->updateFB($fbid,$fbfullname, $_SESSION['EMAIL']);
				header("Location: ".$domain_home."tai-khoan.html");
			} else {
				header("Location: ".$domain_home."tai-khoan-moi.html");
			}
		 }
      /* ---- header location after session ----*/
      
   }else {
      $loginUrl = $helper->getLoginUrl();
      header("Location: ".$loginUrl);
   }
?>