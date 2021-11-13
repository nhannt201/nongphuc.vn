<?php session_start();  ?>
<!DOCTYPE html>
<html lang="vi">
<head>
 <?php include("./inl/head.php"); ?>
</head>
<body id="top_home">
 <?php include("./inl/menu.php"); ?>
 <?php if ((isset($_SESSION['LOG']))) {
	 include("./inl/admin/kiemduyet.php");
 } else {
	echo '<script>window.location.replace("'.$domain_home.'");</script>';
	exit;
	 }
 ?>
<!--Footer navbar-fixed-bottom-->
<?php include("./inl/footer.php"); ?>
</body>
</html>