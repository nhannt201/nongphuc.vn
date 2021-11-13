<?php require_once './inl/VIEW.php';
$getHead = new VIEW();
if (isset($_GET['post'])) {
	$id_thread = trim($_GET['post']);
	if (!is_numeric($id_thread)) {
		echo '<script>window.location.replace("'.$domain_home.'");</script>';
		exit;
	}
} else {
	echo '<script>window.location.replace("'.$domain_home.'");</script>';
	exit;
}
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $getHead->GetSEO($id_thread, "webname"); ?></title>
<meta name="robots" content="index, follow" />
<meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
<meta name="bingbot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
<link rel="canonical" href="<?php echo "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; ?>" />
<meta property="og:locale" content="vi_VN" />
<meta property="og:type" content="article" />
<meta property="og:title" content="<?php echo $getHead->GetSEO($id_thread, "webname"); ?>" />
<meta property="og:description" content="<?php echo $getHead->GetSEO($id_thread, "mota"); ?>" />
<meta property="og:url" content="<?php echo "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; ?>" />
<meta property="og:site_name" content="<?php echo $getHead->GetSEO($id_thread, "webname"); ?>" />
<meta property="og:image" content="<?php echo $getHead->GetSEO($id_thread, "image"); ?>" /> 
<meta name="description" content="<?php echo $getHead->GetSEO($id_thread, "mota"); ?>">
<meta name="keywords" content="<?php echo $getHead->GetSEO($id_thread, "tukhoa"); ?>">
<meta name="author" content="<?php echo $getHead->GetSEO($id_thread, "tacgia"); ?>">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/css/bootstrap-datepicker.min.css'>
<!-- Latest compiled and minified JavaScript -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src='/js/bootstrap-datepicker.min.js'></script>
<!--endXL-->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style><?php include("./css/bsug.style.css");  include("./css/st.smalldev.css"); ?></style>
 <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-69649610-4"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-69649610-4');
</script>
