<?php require_once './inl/ADMIN.php'; 
$getHead = new ADMIN();
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php if (strpos($_SERVER['REQUEST_URI'], 'tai-khoan-moi') !== false): ?>
<title>Đăng ký tài khoản - <?php echo $getHead->GetSEO("webname"); ?></title>
<meta name="robots" content="noindex, nofollow" />
<?php elseif (strpos($_SERVER['REQUEST_URI'], 'dang-bai') !== false): ?>
<title>Đăng bài viết mới - <?php echo $getHead->GetSEO("webname"); ?></title>
<meta name="robots" content="noindex, nofollow" />
<?php elseif (strpos($_SERVER['REQUEST_URI'], 'trang-quan-tri') !== false): ?>
<title>Quản trị viên - <?php echo $getHead->GetSEO("webname"); ?></title>
<meta name="robots" content="noindex, nofollow" />
<?php elseif (strpos($_SERVER['REQUEST_URI'], 'tim-kiem') !== false): ?>
<title>Tìm kiếm - <?php echo $getHead->GetSEO("webname"); ?></title>
<meta name="robots" content="noindex, nofollow" />
<?php elseif (strpos($_SERVER['REQUEST_URI'], 'tai-khoan') !== false): ?>
	<?php if ((isset($_SESSION['LOG']))): ?>
	<title>Quản lí tài khoản - <?php echo $getHead->GetSEO("webname"); ?></title>
	<meta name="robots" content="noindex, nofollow" />
	<?php else: ?>
	<title>Đăng nhập - <?php echo $getHead->GetSEO("webname"); ?></title>
	<meta name="robots" content="noindex, nofollow" />
	<?php endif ?>
<?php else: ?>
<title><?php echo $getHead->GetSEO("webname"); ?></title>
<meta name="robots" content="index, follow" />
<meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
<meta name="bingbot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
<link rel="canonical" href="<?php echo $domain_home; ?>" />
<meta property="og:locale" content="vi_VN" />
<meta property="og:type" content="website" />
<meta property="og:title" content="<?php echo $getHead->GetSEO("webname"); ?>" />
<meta property="og:description" content="<?php echo $getHead->GetSEO("mota"); ?>" />
<meta property="og:url" content="<?php echo $domain_home; ?>" />
<meta property="og:site_name" content="<?php echo $getHead->GetSEO("webname"); ?>" />
<?php if (strlen($getHead->GetSEO("linklogo"))  > 1):?>
<meta property="og:image" content="<?php echo $getHead->GetSEO("linklogo"); ?>" /> <?php endif ?>
 <?php endif ?>
<meta name="description" content="<?php echo $getHead->GetSEO("mota"); ?>">
<meta name="keywords" content="<?php echo $getHead->GetSEO("tukhoa"); ?>">
<meta name="author" content="<?php echo $getHead->GetSEO("webname"); ?>">
<?php //Xu li icon
$linkico = $getHead->GetSEO("linkico");
if ($linkico == "") {
	
} else {
	$ext = pathinfo($linkico, PATHINFO_EXTENSION);
?>
<link rel="icon" 
      type="image/<?php echo $ext; ?>" 
      href="<?php echo $linkico; ?>">
<?php } ?>
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