<?php
session_start();
include("_config.php");
require_once './inl/DB.php';
$user = new DB();
require_once __DIR__ . '/vendor/autoload.php';
use Zalo\Zalo;
 
$config = array(
    'app_id' => $user->GetAppID("zalo"),
    'app_secret' => $user->GetAppSecret("zalo"),
    'callback_url' => $domain_home
);
$zalo = new Zalo($config);

$helper = $zalo -> getRedirectLoginHelper();
$callBackUrl = $domain_home."login-zalo-v2.html";
$loginUrl = $helper->getLoginUrl($callBackUrl); // This is login url
if (isset($_GET['code'])) {} else {
   if (isset( $_SESSION['ZALOID'])) {
	      header("Location: index.php");
   } else {
	      header("Location: ".$loginUrl);
   }
}


