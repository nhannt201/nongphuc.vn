<?php
/* Thiết kế và phát triển bởi Nguyễn Trung Nhẫn
*	Contact me: trungnhan0911@yandex.com
*	Github: https://github.com/nhannt201
*	Vui lòng không xoá những chú thích này để tôn trọng quyền tác giả
*/
//require_once './inl/POST.php';
require_once './inl/ADMIN.php';
require_once './inl/VIEW.php';
require_once './inl/POST.php';
$checkAD = new ADMIN();
$view = new VIEW();
$post = new POST();
$output = "";
$statuss = 1;
if (isset($_GET['post'])) {
	$id_thread = trim($_GET['post']);
	if (!is_numeric($id_thread)) {
		echo '<script>window.location.replace("'.$domain_home.'");</script>';
		exit;
	} else {
		if ($view->checkThread($id_thread)) {
			//Bai viet ton tai va da duoc duyet
			//Lam gi do o day
		} else {
			echo '<script>window.location.replace("'.$domain_home.'");</script>';
			exit;
		}
	}
} else {
	echo '<script>window.location.replace("'.$domain_home.'");</script>';
	exit;
}

?>
<article class="container">
<div class="row">
<div class="col-md-3">
<!--Nam vao vung can le trai-->
<!--<div class="canbang_form">-->

<!--Panel Contact-->
<div class="panel panel-default" id="contact">
<div class="list-group-item activeCS">
Liên hệ tác giả
</div>
<?php if (isset($_SESSION['LOG'])) { ?>
<div class="list-group-item">
<p class="list-group-item-heading"><?php  echo $view->getAuthor($id_thread, "tacgia"); ?></p>
</div>
<div class="list-group-item">
<?php if (!empty($view->getAuthor($id_thread, "phone"))): ?>
<p class="list-group-item-heading">Điện thoại:<a href="tel:<?php  echo $view->getAuthor($id_thread, "phone"); ?>"> <?php  echo $view->getAuthor($id_thread, "phone"); ?></a></p>
<?php else: ?>
<p class="list-group-item-heading">Email:<a href="mailto:<?php  echo $view->getAuthor($id_thread, "email"); ?>"> <?php  echo $view->getAuthor($id_thread, "email"); ?></a></p>
<?php endif ?>
</div>
<div class="list-group-item">
<p class="list-group-item-heading">Địa chỉ:</p>
<?php if (!empty($view->getAuthor($id_thread, "diachi"))):?>
<p class="list-group-item-text"><?php echo $view->getAuthor($id_thread, "diachi"); ?></p>
<?php else: ?>
<p class="list-group-item-text">(Đang cập nhật)</p>
<?php endif ?>
</div>
<div class="list-group-item">
<p class="list-group-item-heading">Giới thiệu:</p>
<p class="list-group-item-text"><?php echo $view->getAuthor($id_thread, "about"); ?></p>
</div>
<?php } else {?>
<div class="list-group-item">
<p class="list-group-item-heading">Bạn cần đăng nhập để xem thông tin tác giả.</p></div>
<?php } ?>
</div>
<!--Panel Inffo-->
<div class="panel panel-default" id="contact">
<div class="list-group-item activeCS">
Thông tin bài viết
</div>

<div class="list-group-item">
<p class="list-group-item-heading"><b>Tác giả:</b> <?php  echo $view->getAuthor($id_thread, "tacgia"); ?></p>
</div>
<div class="list-group-item">
<p class="list-group-item-heading"><b>Bài viết:</b> <?php  echo $view->GetSEO($id_thread, "tengiong"); ?></p>
</div>
<div class="list-group-item">
<p class="list-group-item-heading"><b>Loại nông sản:</b> <?php  echo $view->GetSEO($id_thread, "phanloai"); ?></p>
</div>
<div class="list-group-item">
<p class="list-group-item-heading"><b>Đăng:</b> <?php  echo $view->GetSEO($id_thread, "time"); ?></p>
</div>
<div class="list-group-item">
<p class="list-group-item-heading"><b>Cập nhật:</b> <?php  echo $view->GetSEO($id_thread, "time_mod"); ?></p>
</div>
<div class="list-group-item">
<p class="list-group-item-heading"><b>Trồng:</b> <?php  echo $view->GetSEO($id_thread, "trong"); ?></p>
</div>
<div class="list-group-item">
<p class="list-group-item-heading"><b>Thu hoạch:</b> <?php  echo $view->GetSEO($id_thread, "thuhoach"); ?></p>
</div>
<div class="list-group-item">
<p class="list-group-item-heading"><b>Vị trí:</b> <a target="_bank" href="https://www.google.com/maps/place/<?php  echo $view->GetSEO($id_thread, "vitri_link"); ?>"><?php  echo $view->GetSEO($id_thread, "vitri"); ?></a></p>
</div>
<div class="list-group-item">
<?php if (isset($_SESSION['LOG'])): ?>
<?php if ($post->showEdit($view->getAuthor($id_thread, "email"), $id_thread, "public_loc") == 0): ?>
<?php if ($view->GetSEO($id_thread, "toado")): ?>
<p class="list-group-item-heading"><b>Toạ độ:</b> <a target="_bank" href="https://www.google.com/maps/place/<?php  echo $view->GetSEO($id_thread, "toado"); ?>"><?php  echo $view->GetSEO($id_thread, "toado"); ?></a></p>
<?php else: ?>
<p class="list-group-item-heading"><b>Toạ độ:</b> Đang cập nhật</p>
<?php endif ?>
<?php else: ?>
<p class="list-group-item-heading"><b>Toạ độ:</b> Đang cập nhật</p>
<?php endif ?>
<?php else: ?>
<p class="list-group-item-heading"><b>Toạ độ:</b> Bạn cần đăng nhập để xem thông tin này.</p>
<?php endif ?>
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
<?php if ($getADS->GetADS("ads1")): ?>
		<!--Panel Ads-->
		<div class="panel panel-default" id="ads-vuong">
		<a rel="nofollow" href="<?php echo $getADS->GetADS("ads1_link"); ?>" target="_blank"><img src="<?php echo $getADS->GetADS("ads1"); ?>" width="100%"/></a>
		</div>
		<?php endif ?>
</div>
<!--Vung can le phai-->
	<div class="col-md-8">
			<!--VIEW-->
		<div class="panel panel-custom">	

		  <div class="panel-body">
			<!--Slide-->
			 <div id="myCarousel" class="carousel slide" data-ride="carousel">
				<!-- Indicators -->
				<ol class="carousel-indicators">
				  <?php $view->showNumSlide($id_thread); ?>
				</ol>

				<!-- Wrapper for slides -->
				<div class="carousel-inner">

				  <?php $view->showSlideView($id_thread); ?>
			  
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
	

		  </div>

		</div>
		
			<!--Content-->
			<?php $view->showThreadView($id_thread); ?>

		  
		<?php if ($getADS->GetADS("ads3")): ?>
		<!--Panel Ads Hoz-->
		<div class="panel panel-default" id="ads-right">
		<a rel="nofollow" href="<?php echo $getADS->GetADS("ads3_link"); ?>" target="_blank"><img src="<?php echo $getADS->GetADS("ads3"); ?>" width="100%"/></a>
		</div>
		<?php endif ?>
		
		<!--end-->
	</div>

	</div>
</div>
</article>