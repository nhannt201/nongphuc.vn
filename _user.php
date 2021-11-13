<?php session_start();  ?>
<!DOCTYPE html>
<html lang="vi">
<head>
 <?php include("./inl/head.php"); ?>
</head>
<body id="top_home">
 <?php include("./inl/menu.php"); ?>
 <?php if ((isset($_SESSION['LOG']))) {
	 include("./inl/user/profile.php");
 } else {include("./inl/user/login.php"); }
 ?>
<!--Footer navbar-fixed-bottom-->
<?php include("./inl/footer.php"); ?>
</body>
</html>