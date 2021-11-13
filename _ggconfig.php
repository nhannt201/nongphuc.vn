<?php session_start();
   //set definoe login google
   require_once './inl/DB.php';
   $user = new DB();
	    define('GOOGLE_APP_ID',$user->GetAppID("google"));
	    define('GOOGLE_APP_SECRET',$user->GetAppSecret("google"));
	    define('GOOGLE_APP_CALLBACK_URL',$domain_home.'login-google.html');
 /**
	     * CALL GOOGLE API
	     */
	    require_once './vendor2/autoload.php';
	    $client = new Google_Client();
	    $client->setClientId(GOOGLE_APP_ID);
	    $client->setClientSecret(GOOGLE_APP_SECRET);
	    $client->setRedirectUri(GOOGLE_APP_CALLBACK_URL);
	    $client->addScope("email");
	    $client->addScope("profile");
	    
	    if (isset($_GET['code'])) {
	        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
	       // print_r($token);
	        $client->setAccessToken($token['access_token']);
	 
	        // get profile info
	        $google_oauth = new Google_Service_Oauth2($client);
	        $google_account_info = $google_oauth->userinfo->get();
	        $email =  $google_account_info->email;
	        $name =  $google_account_info->name;
	        $idgg = $google_account_info->id;
	       /**
	        * CHECK EMAIL AND NAME IN DATABASE
	        */
	         /* ---- Session Variables -----*/
			  $_SESSION['GGID'] = $idgg;
			  $_SESSION['FULLNAME'] = $name;
			  $_SESSION['EMAIL2'] =  $email;
			  //Initialize DB class and add
				
				 if (($user->googleCheck($idgg,$name,$email))) {
						header("Location: ".$domain_home);
				 } else {
						if (isset($_SESSION['LOG'])) {
						$user->updateGG($idgg,$name, $_SESSION['EMAIL']);
						header("Location: ".$domain_home."tai-khoan.html");
						} else {
							header("Location: ".$domain_home."tai-khoan-moi.html");
						}
				 }
		 /////////////////////////////////////////
	    } else {
	        /**
	         * IF YOU DON'T LOGIN GOOGLE
	         * YOU CAN SEEN AGAIN GOOGLE_APP_ID, GOOGLE_APP_SECRET, GOOGLE_APP_CALLBACK_URL
	         */
	       // echo "<a href='".$client->createAuthUrl()."'>Google Login</a>";
			 header("Location: ".$client->createAuthUrl());
	    }

