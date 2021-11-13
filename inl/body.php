<?php require_once './inl/POST.php';
$newPS = new POST();?>
<div class="container">

<!--
<header class="jumbotron text-center">
<h2>Saigonica - Nền tảng Blog nhanh!</h2>
<p class="text-warning">Chia sẻ mọi cảm xúc của bạn!</p>
</header> -->
<article>
<div class="row">
<!--Left-->
<div class="col-md-3">
<?php if (isset($_SESSION['LOG'])) { if($newPS->checkFirstThread($email)){ ?>
<div class="alert alert-warning" role="alert"><a href="/dang-bai.html">Bấm vào đây</a> để bắt đầu <b><mark><a href="/dang-bai.html">Đăng bài</a></mark></b> đầu tiên về sản phẩm của bạn!</div>
<?php } } ?>
<!--Panel Intro-->
<div class="panel panel-default" id="about">
<div class="list-group-item activeCS">
Giới thiệu
</div>
<div class="list-group-item">
<?php if (strlen($getHead->GetSEO("linklogo"))  > 1): ?>
<img src="<?php echo $getHead->GetSEO("linklogo"); ?>" width="100%" height="50%"/><br/><hr/>
<?php endif ?>
<p class="list-group-item-heading" align="justify"><?php echo $getHead->GetSEO("mota"); ?></p>
</div>
</div>
<?php 
if (isset($_SESSION['ADMIN'])) { //chi cho admin tim kiem
				if ($_SESSION['ADMIN'] == 0) { 
?>
<!--Panel Search Admin-->
<div class="panel panel-default">
<div class="list-group-item activeCS">
Công cụ tìm kiếm dành cho Admin
</div>
<div class="list-group-item">
<form method="get" action="/search-vip" id="searchForm" class="searchForm">
<select class="form-control" name="tinh_tp" id="tinh_tp" onchange="clickProvince()">
<option value="0">--Tỉnh/Thành phố--</option>
<?php
require_once './inl/DB.php';
$newDB = new DB();
$newDB->showProvince();
?>
</select><br/>
<select class="form-control" name="quan_huyen" id="quan_huyen" onchange="clickDistrict()">
<option value="0">--Quận/Huyện--</option>
</select><br/>
<select class="form-control" name="phuong_xa" id="phuong_xa">
<option value="0">--Xã/Phường/Thị Trấn--</option>
</select><br/>
<!--<div class="form-group">
  <input type="text" name="tk" id="tk" class="form-control" placeholder="Tên sản phẩm (nếu có)">
</div>-->
<select class="form-control" name="nongpham" id="nongpham">
<option value="0">--Tất cả--</option>
<?php require_once './inl/DB.php';
$newDB = new DB();
$newDB->showNongSan();
?>
</select><br/>

	 <button type="submit" class="btn btn-success btn-block" width="100%"><i class="glyphicon glyphicon-search"></i> Tìm kiếm</button></div>

</form>
</div>
<?php }
} else { ?>
<!--Panel Search-->
<div class="panel panel-default">
<div class="list-group-item activeCS">
Tìm kiếm nông sản số lượng lớn
</div>
<div class="list-group-item">
<form method="get" action="/tim-kiem" id="searchForm" class="searchForm">
<select class="form-control" name="tinh_tp" id="tinh_tp" onchange="clickProvince()">
<option value="0">--Tỉnh/Thành phố--</option>
<?php
require_once './inl/DB.php';
$newDB = new DB();
$newDB->showProvince();
?>
</select><br/>
<select class="form-control" name="quan_huyen" id="quan_huyen" onchange="clickDistrict()">
<option value="0">--Quận/Huyện--</option>
</select><br/>
<select class="form-control" name="phuong_xa" id="phuong_xa">
<option value="0">--Xã/Phường/Thị Trấn--</option>
</select><br/>
<!--<div class="form-group">
  <input type="text" name="tk" id="tk" class="form-control" placeholder="Tên sản phẩm (nếu có)">
</div>-->
<select class="form-control" name="nongpham" id="nongpham">
<option value="0">--Tất cả--</option>
<?php
require_once './inl/DB.php';
$newDB = new DB();
$newDB->showNongSan();
?>
</select><br/>

	 <button type="submit" class="btn btn-success btn-block" width="100%"><i class="glyphicon glyphicon-search"></i> Tìm kiếm</button></div>

</form>
</div> <?php } ?>
  <!--JS_XL-->
 <script type="text/javascript" src="/js/jquery.qq.js"></script>
<?php require_once './inl/ADS.php';
		$getADS = new ADS();
		if ($getADS->GetADS("ads1")):
		?>
		<!--Panel Ads-->
		<div class="panel panel-default" id="ads-vuong">
		<a rel="nofollow" href="<?php echo $getADS->GetADS("ads1_link"); ?>" target="_blank"><img src="<?php echo $getADS->GetADS("ads1"); ?>" width="100%"/></a>
		</div>
		<?php endif ?>
<!--Panel Contact-->
<div class="panel panel-default" id="contact">
<div class="list-group-item activeCS">
Liên hệ để có nhiều tìm kiếm hơn
</div>
<div class="list-group-item">
<p class="list-group-item-heading"><a href="tel:<?php echo $getHead->GetCONTACT("phone"); ?>"><span class="glyphicon glyphicon-earphone"></span> <?php echo $getHead->GetCONTACT("phone"); ?></a></p>
</div>
<div class="list-group-item">
<p class="list-group-item-heading"><a href="mailto:<?php echo $getHead->GetCONTACT("email"); ?>"><span class="glyphicon glyphicon-envelope"></span> <?php echo $getHead->GetCONTACT("email"); ?></a></p>
</div>
<div class="list-group-item">
<p class="list-group-item-heading">Địa chỉ:</p>
<p class="list-group-item-text"><span class="glyphicon glyphicon-home"></span> <?php echo $getHead->GetCONTACT("diachi"); ?></p>
</div>
</div>
<?php require_once './inl/ADS.php';
		$getADS = new ADS();
		if ($getADS->GetADS("ads2")):
		?>
		<!--Panel Ads-->
		<div class="panel panel-default" id="ads-cndai">
		<a rel="nofollow" href="<?php echo $getADS->GetADS("ads2_link"); ?>" target="_blank"><img src="<?php echo $getADS->GetADS("ads2"); ?>" width="100%"/></a>
		</div>
		<?php endif ?>
</div>

<!--Nam vao vung can le phai-->
<div class="col-md-9">

 <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
		<?php  $getHead->getSlideHome(); ?>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Trước</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Sau</span>
    </a>
  </div>
<!--Newfeed-->
<div class="panelCS panel-custom">
  <div class="panel-heading">Bài viết mới</div>

<div class="panel-body">

<div class="panelCS panel-custom">

<?php
require_once './inl/POST.php';
$show_subject = new POST();
$show_subject->showThread();
?>

</div>
</div>
</div>
</article>
</div>