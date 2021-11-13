<?php
session_start();
include("_config.php");
require_once './inl/DB.php';
require_once __DIR__ . '/vendor/autoload.php';
use Zalo\Zalo;
 
$config = array(
    'app_id' => '',
    'app_secret' => '',
    'callback_url' => $domain_home
);
$zalo = new Zalo($config);

$helper = $zalo -> getRedirectLoginHelper();
$callBackUrl = $domain_home."login-zalo-v2.html";


$oauthCode = isset($_GET['code']) ? $_GET['code'] : "THIS NOT CALLBACK PAGE !!!"; // get oauthoauth code from url params
$accessToken = $helper->getAccessToken($callBackUrl); // get access token
if ($accessToken != null) {
    $expires = $accessToken->getExpiresAt(); // get expires time
}
//Co token roi lay thong tin ca nhan
$get_info_zl = file_get_contents("https://graph.zalo.me/v2.0/me?access_token=".$accessToken."&fields=id,birthday,name,gender,picture");
$info = (json_decode($get_info_zl, true));
$name_us = $info['name'];
$id_us = $info['id'];

 /* ---- Session Variables -----*/
			  $_SESSION['ZLID'] = $info['id'];
			  $_SESSION['FULLNAME'] = $info['name'];
			  //Initialize DB class and add
				$user = new DB();
				 if (($user->zaloCheck($id_us,$name_us))) {
						header("Location: ".$domain_home);			  
				 } else {
				     if (isset($_SESSION['LOG'])) {
						$user->updateZL($id_us,$fbfullname, $_SESSION['EMAIL']);
						header("Location: ".$domain_home."tai-khoan.html");
					} else {
						header("Location: ".$domain_home."tai-khoan-moi.html");
					}
				 }
				 
