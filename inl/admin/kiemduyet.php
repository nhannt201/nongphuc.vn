<?php
/* Thiết kế và phát triển bởi Nguyễn Trung Nhẫn
*	Contact me: trungnhan0911@yandex.com
*	Github: https://github.com/nhannt201
*	Vui lòng không xoá những chú thích này để tôn trọng quyền tác giả
*/
require_once './inl/ADMIN.php';
require_once './inl/POST.php';
$admin = new ADMIN();
$output = "";
if (isset($_SESSION['EMAIL'])) { //Kiem tra email ton tai chua
	$email = $_SESSION['EMAIL'];
	$admin->CheckAdminMod($email);
	if (isset($_SESSION['ADMIN'])) { 
	} else {
	echo '<script>window.location.replace("'.$domain_home.'");</script>';
	exit;
	}
} else {
	//Su dung SDT thi:
		if (isset($_SESSION['PHONE'])) { //Kiem tra email ton tai chua
			$email = $_SESSION['PHONE'];
			$admin->CheckAdminMod($email);
			if (isset($_SESSION['ADMIN'])) { 
			} else {
			echo '<script>window.location.replace("'.$domain_home.'");</script>';
			exit;
			}
		} else {
			echo '<script>window.location.replace("'.$domain_home.'");</script>';
			exit;
		}
}
if (isset($_POST['post_xoa'])) {
	$idPL = $_POST['id_PL'];
	$idTH = $_POST['id_thread'];
	if (!$admin->getDuyetPhanloai($idPL)) { //Kiem tra xem phan loai nong san nay da dc duyet hay chua
			$admin->XoaPLvsThread($idPL, $idTH);
			$output = '<div class="alert alert-success" role="alert">Đã xoá bài viết và chuyên mục!</div>';
			echo '<script>window.location.replace("'.$domain_home.'kiem-duyet-vien.html");</script>';
	} else {
		$admin->XoaThread($idTH);
		$output = '<div class="alert alert-success" role="alert">Đã xoá bài viết!</div>';
		echo '<script>window.location.replace("'.$domain_home.'kiem-duyet-vien.html");</script>';
	}
}
if (isset($_POST['post_duyet'])) {
	$idPL = $_POST['id_PL'];
	$idTH = $_POST['id_thread'];
	if (!$admin->getDuyetPhanloai($idPL)) { //Kiem tra xem phan loai nong san nay da dc duyet hay chua
			$admin->DuyetPLvsThread($idPL, $idTH);
			$output = '<div class="alert alert-success" role="alert">Đã duyệt bài viết và chuyên mục!</div>';
			echo '<script>window.location.replace("'.$domain_home.'kiem-duyet-vien.html");</script>';
	} else {
		$admin->DuyetThread($idTH);
		$output = '<div class="alert alert-success" role="alert">Đã duyệt bài viết!</div>';
		echo '<script>window.location.replace("'.$domain_home.'kiem-duyet-vien.html");</script>';
	}
}
//Post ghichu
if (isset($_POST['post_canhbao'])) {
	$canhbao = trim(htmlspecialchars($_POST['ghichu']));
	$idTH = $_POST['id_thread'];
	if (strlen($canhbao) < 2) {
		$output = '<div class="alert alert-warning" role="alert">Cảnh báo quá ngắn. Vui lòng thử lại!</div>';
	} else {
		$admin->sendCanhBao($idTH, $canhbao);
		$output = '<div class="alert alert-success" role="alert">Đã gửi cảnh báo và bỏ qua bài viết!</div>';
		echo '<script>window.location.replace("'.$domain_home.'kiem-duyet-vien.html");</script>';
	}

}
?>
<article class="container">
<div class="canbang_form">
<div class="page-header">

  <h1>Kiểm duyệt bài viết</h1>

</div>
<?php echo $output; ?>
	   	
		<!--KD-->
		<div class="panel panel-custom">

		  <div class="panel-heading" id="SEO">Nội dung cần duyệt</div>

		  <div class="panel-body">
				<?php $admin->showDuyet(); ?>

		</div>
		<!--End Form nho-->
		
				
		</div>

	
	</div>
</article>