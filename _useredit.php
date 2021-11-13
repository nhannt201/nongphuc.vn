<?php session_start(); 
 include("_config.php");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
 <?php include("./inl/head.php"); ?>
</head>
<body id="top_home">
 <?php include("./inl/menu.php"); ?>
 <?php if ((isset($_SESSION['LOG']))) {
	  require_once './inl/PROFILE.php';
	  $profile = new PROFILE();
	   if (isset($_SESSION['PHONE'])) {
		  //Neu la SDT
		  if ($profile->CheckPhone($_SESSION['PHONE'])) {
		  	 include("./inl/user/edit.php");
		  }
	  } else {
		  //Neu dung Email
		   if ($profile->CheckPhone($_SESSION['EMAIL'])) {
		  	 include("./inl/user/edit.php");
		  } else {
			  echo '<div class="text-center"><div class="alert alert-warning" role="alert">Trước khi đăng bài, bạn cần phải cập nhật đầy đủ thông tin cần thiết bao gồm số điện thoại. <a href="/tai-khoan.html">Nhấn vào đây</a> để cập nhật thông tin</div></div>';
		  }
	  }
 } else {
	echo '<script>window.location.replace("'.$domain_home.'");</script>';
	exit;
}
 ?>
<!--Footer navbar-fixed-bottom-->
<?php include("./inl/footer.php"); ?>
</body>
</html>