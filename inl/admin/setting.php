<?php 
/* Thiết kế và phát triển bởi Nguyễn Trung Nhẫn
*	Contact me: trungnhan0911@yandex.com
*	Github: https://github.com/nhannt201
*	Vui lòng không xoá những chú thích này để tôn trọng quyền tác giả
*/
require_once './inl/ADMIN.php';
require_once './inl/DB.php';
$getApp = new DB();	
$admin = new ADMIN();
$output = "";
if (isset($_SESSION['EMAIL'])) { //Kiem tra email ton tai chua
	$email = $_SESSION['EMAIL'];
	$admin->CheckAdminMod($email);
		if (isset($_SESSION['ADMIN'])) {
				if ($_SESSION['ADMIN'] == 0) { } else {
					echo '<script>window.location.replace("'.$domain_home.'");</script>';
					exit;
					}
		} else {
		echo '<script>window.location.replace("'.$domain_home.'");</script>';
		exit;
		}
} else {
	//Neu dung SDT
		if (isset($_SESSION['PHONE'])) { //Kiem tra email ton tai chua
		$email = $_SESSION['PHONE'];
		$admin->CheckAdminMod($email);
			if (isset($_SESSION['ADMIN'])) {
					if ($_SESSION['ADMIN'] == 0) { } else {
						echo '<script>window.location.replace("'.$domain_home.'");</script>';
						exit;
						}
			} else {
			echo '<script>window.location.replace("'.$domain_home.'");</script>';
			exit;
			}
		} else {
			echo '<script>window.location.replace("'.$domain_home.'");</script>';
			exit;
		}
}
//Kiem tra POST SEO
if (isset($_POST['post_seo'])) {
	$seoname = trim(htmlspecialchars($_POST['webname']));
	$seoMota = trim(htmlspecialchars($_POST['aboutweb']));
	$seoTukhoa = trim(htmlspecialchars($_POST['tukhoa']));
	$seoIco = trim(($_POST['linkico']));
	$seoLogo = trim(($_POST['linklogo']));
	if (strlen($seoname) < 2) {$output = '<div class="alert alert-warning" role="alert">Tên web quá ngắn. Vui lòng thử lại!</div>'; }
	if (strlen($seoname) < 50) {$output = '<div class="alert alert-warning" role="alert">Mô tả web quá ngắn. Vui lòng thử lại!</div>'; }
	$admin->updateSEO($seoname, $seoMota, $seoTukhoa, $seoIco, $seoLogo);
	$output = '<div class="alert alert-success" role="alert">Lưu <b>Cấu hình SEO</b> hoàn tất!</div>'; 
	echo '<script>window.location.replace("'.$domain_home.'trang-quan-tri.html#SEO");</script>';
}
//Kiem tra POST Contact
if (isset($_POST['post_info'])) {
	$contactP = trim(($_POST['adminphone']));
	$contactE = trim(($_POST['adminemail']));
	$contactA = trim(htmlspecialchars($_POST['adminadr']));
	if (!is_numeric($contactP)) {$output = '<div class="alert alert-danger" role="alert">Số điện thoại không hợp lệ. Vui lòng thử lại!</div>';}
	$admin->updateCONTACT($contactP, $contactE, $contactA);
	$output = '<div class="alert alert-success" role="alert">Lưu <b>Thông tin liên hệ</b> hoàn tất!</div>';
	echo '<script>window.location.replace("'.$domain_home.'trang-quan-tri.html#contact");</script>';
}
//Kiem tra POST Ads
if (isset($_POST['post_ads_vuong'])) {
	$img = trim(($_POST['ads_vuong']));
	$link = trim(($_POST['ads_vuong_link']));
	if (filter_var($link, FILTER_VALIDATE_URL) === FALSE) {$output = '<div class="alert alert-danger" role="alert">Link không hợp lệ. Vui lòng thử lại!</div>'; }
	if (filter_var($img, FILTER_VALIDATE_URL) === FALSE) {$output = '<div class="alert alert-danger" role="alert">Link không hợp lệ. Vui lòng thử lại!</div>'; }
	$admin->updateADS($img, $link, 1);
	$output = '<div class="alert alert-success" role="alert">Lưu <b>Quảng cáo 1</b> hoàn tất!</div>';
	echo '<script>window.location.replace("'.$domain_home.'trang-quan-tri.html#ads_st");</script>';
	
}
if (isset($_POST['post_ads_hcn'])) {
	$img = trim(($_POST['ads_hcn']));
	$link = trim(($_POST['ads_hcn_link']));
	if (filter_var($link, FILTER_VALIDATE_URL) === FALSE) {$output = '<div class="alert alert-danger" role="alert">Link không hợp lệ. Vui lòng thử lại!</div>'; }
	if (filter_var($img, FILTER_VALIDATE_URL) === FALSE) {$output = '<div class="alert alert-danger" role="alert">Link không hợp lệ. Vui lòng thử lại!</div>'; }
	$admin->updateADS($img, $link, 2);
	$output = '<div class="alert alert-success" role="alert">Lưu <b>Quảng cáo 2</b> hoàn tất!</div>';
	echo '<script>window.location.replace("'.$domain_home.'trang-quan-tri.html#ads_st2");</script>';
	
}
if (isset($_POST['post_ads_banner'])) {
	$img = trim(($_POST['ads_banner']));
	$link = trim(($_POST['ads_banner_link']));
	if (filter_var($link, FILTER_VALIDATE_URL) === FALSE) {$output = '<div class="alert alert-danger" role="alert">Link không hợp lệ. Vui lòng thử lại!</div>'; }
	if (filter_var($img, FILTER_VALIDATE_URL) === FALSE) {$output = '<div class="alert alert-danger" role="alert">Link không hợp lệ. Vui lòng thử lại!</div>'; }
	$admin->updateADS($img, $link, 3);
	$output = '<div class="alert alert-success" role="alert">Lưu <b>Quảng cáo 3</b> hoàn tất!</div>';
	echo '<script>window.location.replace("'.$domain_home.'trang-quan-tri.html#ads_st3");</script>';
	
}
//Kiem tra POST Slide
//Code html slide da duoc tach ra file slide_st_advenced. Vi tinh nang nay khong can thiet ngay luc nay.
//Thu vien de add edit post slide van con
/*
if (isset($_POST['post_slide'])) {
	//Slide1
	$slideH1 = trim(($_POST['heading1']));
	$slideS1 = trim(($_POST['txt1']));
	$slideI1 = trim(($_POST['linkimg1']));
	if (strlen($slideH1) < 2) {$output = '<div class="alert alert-danger" role="alert">Tiêu đề Slide 1 quá ngắn. Vui lòng thử lại!</div>';}
	if (strlen($slideS1) < 2) {$output = '<div class="alert alert-danger" role="alert">Mô tả Slide 1 quá ngắn. Vui lòng thử lại!</div>';}
	if (strlen($slideI1) < 2) {$output = '<div class="alert alert-danger" role="alert">Link ảnh Slide 1 không hợp lệ. Vui lòng thử lại!</div>';}
	//Slide2
	$slideH2 = trim(($_POST['heading2']));
	$slideS2 = trim(($_POST['txt2']));
	$slideI2 = trim(($_POST['linkimg2']));
	if (strlen($slideH2) < 2) {$output = '<div class="alert alert-danger" role="alert">Tiêu đề Slide 2 quá ngắn. Vui lòng thử lại!</div>';}
	if (strlen($slideS2) < 2) {$output = '<div class="alert alert-danger" role="alert">Mô tả Slide 2 quá ngắn. Vui lòng thử lại!</div>';}
	if (strlen($slideI2) < 2) {$output = '<div class="alert alert-danger" role="alert">Link ảnh Slide 2 không hợp lệ. Vui lòng thử lại!</div>';}
	//Slide3
	$slideH3 = trim(($_POST['heading3']));
	$slideS3 = trim(($_POST['txt3']));
	$slideI3 = trim(($_POST['linkimg3']));
	if (strlen($slideH3) < 2) {$output = '<div class="alert alert-danger" role="alert">Tiêu đề Slide 3 quá ngắn. Vui lòng thử lại!</div>';}
	if (strlen($slideS3) < 2) {$output = '<div class="alert alert-danger" role="alert">Mô tả Slide 3 quá ngắn. Vui lòng thử lại!</div>';}
	if (strlen($slideI3) < 2) {$output = '<div class="alert alert-danger" role="alert">Link ảnh Slide 3 không hợp lệ. Vui lòng thử lại!</div>';}
	//Update
	$admin->updateSlide(1, $slideH1, $slideS1, $slideI1); //Slide1
	$admin->updateSlide(2, $slideH2, $slideS2, $slideI2); //Slide2
	$admin->updateSlide(3, $slideH3, $slideS3, $slideI3); //Slide3
	$output = '<div class="alert alert-success" role="alert">Lưu <b>Slide</b> hoàn tất!</div>'; 
	echo '<script>window.location.replace("'.$domain_home.'trang-quan-tri.html#Slide");</script>';
}*/
//Kiem tra POST FB APP
if (isset($_POST['post_facebook'])) {
	$IDFB = trim(($_POST['idfb']));
	$KEYFB = trim(($_POST['keyfb']));
	if (strlen($IDFB) < 2) {$output = '<div class="alert alert-danger" role="alert">ID Facebook không hợp lệ. Vui lòng thử lại!</div>';}
	if (strlen($KEYFB) < 2) {$output = '<div class="alert alert-danger" role="alert">KEY Facebook không hợp lệ. Vui lòng thử lại!</div>';}
	//Update
	$admin->updateApp("facebook", $IDFB, $KEYFB);
	$output = '<div class="alert alert-success" role="alert">Lưu <b>Facebook App</b> thành công!</div>'; 
	echo '<script>window.location.replace("'.$domain_home.'trang-quan-tri.html#updateFB");</script>';
}
//Kiem tra POST GG APP
if (isset($_POST['post_google'])) {
	$IDGG = trim(($_POST['idgg']));
	$KEYGG = trim(($_POST['keygg']));
	if (strlen($IDGG) < 2) {$output = '<div class="alert alert-danger" role="alert">ID Google không hợp lệ. Vui lòng thử lại!</div>';}
	if (strlen($KEYGG) < 2) {$output = '<div class="alert alert-danger" role="alert">KEY Google không hợp lệ. Vui lòng thử lại!</div>';}
	//Update
	$admin->updateApp("google", $IDGG, $KEYGG);
	$output = '<div class="alert alert-success" role="alert">Lưu <b>Google App</b> thành công!</div>'; 
	echo '<script>window.location.replace("'.$domain_home.'trang-quan-tri.html#updateGG");</script>';
}
//Kiem tra POST ZL APP
if (isset($_POST['post_zalo'])) {
	$IDZL = trim(($_POST['idzl']));
	$KEYZL = trim(($_POST['keyzl']));
	if (strlen($IDZL) < 2) {$output = '<div class="alert alert-danger" role="alert">ID Zalo không hợp lệ. Vui lòng thử lại!</div>';}
	if (strlen($KEYZL) < 2) {$output = '<div class="alert alert-danger" role="alert">KEY Zalo không hợp lệ. Vui lòng thử lại!</div>';}
	//Update
	$admin->updateApp("google", $IDZL, $KEYZL);
	$output = '<div class="alert alert-success" role="alert">Lưu <b>Zalo App</b> thành công!</div>'; 
	echo '<script>window.location.replace("'.$domain_home.'trang-quan-tri.html#updateZL");</script>';
}
//Kiem tra Post KDV
if (isset($_POST['post_kdv'])) {
	$email_kdv = trim(($_POST['email_pQ']));
	if ($admin->AddKDV($email_kdv)) {
		$output = '<div class="alert alert-success" role="alert">Thêm <b>KDV</b> thành công!</div>'; 
		echo '<script>window.location.replace("'.$domain_home.'trang-quan-tri.html#phanquyen");</script>';
	} else {
		$output = '<div class="alert alert-warning" role="alert">Người bạn vừa thêm để làm KDV chưa có tài khoản trên hệ thống hoặc đã tồn tại!</div>';
	}
}
//Kiem tra Post QTV
if (isset($_POST['post_qtv'])) {
	$email_kdv = trim(($_POST['email_QTV']));
	if ($admin->AddQTV($email_kdv)) {
		$output = '<div class="alert alert-success" role="alert">Thêm <b>QTV</b> thành công!</div>'; 
		echo '<script>window.location.replace("'.$domain_home.'trang-quan-tri.html#phanquyenAD");</script>';
	} else {
		$output = '<div class="alert alert-warning" role="alert">Người bạn vừa thêm để làm QTV chưa có tài khoản trên hệ thống hoặc đã tồn tại!</div>';
	}
}
//Kiem tra Post Add Phan loai NS
if (isset($_POST['post_pl_add'])) {
	$tenphanloai = trim(htmlspecialchars($_POST['nongsan_add']));
	if (strlen($tenphanloai) < 2) {$output = '<div class="alert alert-danger" role="alert">Không được bỏ trống Tên nông sản. Vui lòng thử lại!</div>';} 
	else { 
	$admin->AddNS($tenphanloai);
	$output = '<div class="alert alert-success" role="alert">Thêm <b>Tên nông sản</b> thành công!</div>'; 
	echo '<script>window.location.replace("'.$domain_home.'trang-quan-tri.html#phanloai");</script>';
	}
}
//Kiem tra Post Xoa Phan loai NS
if (isset($_POST['post_pl_xoa'])) {
	$idPL = trim(htmlspecialchars($_POST['phanloaiNS']));
	$admin->XoaNS($idPL);
	$output = '<div class="alert alert-success" role="alert">Đã xoá <b>Tên nông sản</b> được chọn thành công!</div>'; 
	echo '<script>window.location.replace("'.$domain_home.'trang-quan-tri.html#phanloai");</script>';
}
//Kiem tra PostLoc TuKhoa
if (isset($_POST['xoaTK'])) {
	$tukhoa = trim(htmlspecialchars($_POST['tukhoaxau']));
	$admin->XoaTuKhoa($tukhoa);
	$output = '<div class="alert alert-success" role="alert">Đã xoá <b>Từ khoá</b> được chọn thành công!</div>'; 
	echo '<script>window.location.replace("'.$domain_home.'trang-quan-tri.html#boloc");</script>';
}
if (isset($_POST['themTK'])) {
	$tukhoa = trim(htmlspecialchars($_POST['tukhoamoi']));
	$admin->ThemTuKhoa($tukhoa);
	$output = '<div class="alert alert-success" role="alert">Đã thêm <b>Từ khoá</b> mới!</div>'; 
	echo '<script>window.location.replace("'.$domain_home.'trang-quan-tri.html#boloc");</script>';
}
?>
<article class="container">
<div class="row">
<div class="col-md-7">
<!--Nam vao vung can le trai-->
<!--<div class="canbang_form">-->
<div class="page-header">

  <h1>Quản trị viên trang web</h1>

</div>
<!--Setting-->
<?php echo $output; ?>
		<!--Quan li thanh vien-->
		<div class="panel panel-custom">

		  <div class="panel-heading" id="member_st">Quản lí thành viên</div>

		  <div class="panel-body">
				<div class="alert alert-info" role="alert">Khi xoá thành viên, các bài viết của thành viên sẽ chuyển về cho Admin</div>
				 <!--Timkiem-->
				<div class="input-group">
				<span class="input-group-addon">Tìm thành viên</span>
				<input type="url" class="form-control" id="tv_tim" name="tv_tim"  placeholder="Tên thành viên, sđt, email, v.v...">
				</div><br/>
				<!--POST-->	
					<div class="text-right">
					 <button class="btn btn-success btn-sm" onClick="clickTimMEM()">Tìm thành viên</button>
					</div>
						<div class="row">
					<div class="col-md-12">
				<div name="caibangIF" id="caibangIF" class="table-responsive">
								<?php echo $admin->getThanhVien(); ?>
				</div></div></div>
				

		  </div>
		</div>
		<!--Cau hinh SEO-->
		<div class="panel panel-custom">

		  <div class="panel-heading" id="SEO">Cấu hình SEO</div>

		  <div class="panel-body">
				<form method="POST" action="/trang-quan-tri.html#update">
				<!--Ten web-->
				<div class="input-group">
				<span class="input-group-addon">Tên web</span>
				<input type="text" class="form-control" id="webname" name="webname" value="<?php echo $admin->GetSEO("webname"); ?>" placeholder="Ví dụ: Nông dân bán hàng" required="required">
				</div><br/>
				<!--Mota-->
				 <label>Mô tả trang web: 50–160 từ</label>
				   <div class="form-group">
					<textarea class="form-control" id="aboutweb" name="aboutweb" rows="2" maxlength="220" placeholder="Ví dụ: Đây là trang web để..." ><?php echo $admin->GetSEO("mota"); ?></textarea>
				  </div>
				 <!--Tu khoa-->
				 <div class="alert alert-info" role="alert">Lưu ý, từ khoá ngăn cách bằng dấu phẩy và chỉ nên để các từ khoá chính.</div>
				<div class="input-group">
				<span class="input-group-addon">Từ khoá</span>
				<input type="text" class="form-control" id="tukhoa" name="tukhoa" value="<?php echo $admin->GetSEO("tukhoa"); ?>" placeholder="Ví dụ: bán hàng online, mua bán cây giống." required="required">
				</div><br/>
				 <!--Link ico-->
				 <div class="alert alert-info" role="alert">Link icon. Nên để link file ico. (Nếu có)</div>
				<div class="input-group">
				<span class="input-group-addon">Link icon</span>
				<input type="url" class="form-control" id="linkico" name="linkico" value="<?php echo $admin->GetSEO("linkico"); ?>" placeholder="http://abc.com/images/ico.ico">
				</div><br/>
				 <!--Link Logo-->
				<div class="input-group">
				<span class="input-group-addon">Link Logo</span>
				<input type="url" class="form-control" id="linklogo" name="linklogo" value="<?php echo $admin->GetSEO("linklogo"); ?>" placeholder="Link Logo trang web của bạn. Định dạng nên là PNG hoặc JPG">
				</div><br/>
				<!--POST-->	
					<div class="text-right">
					 <input type="submit" class="btn btn-success btn-sm" name="post_seo" id="post_seo" value="Lưu cấu hình"/>
					</div></form>
		  </div>

		</div>
		<!--Conact-->
		<div class="panel panel-custom">

		  <div class="panel-heading" id="contact">Thông tin liên hệ</div>

		  <div class="panel-body">
				<form method="POST" action="/trang-quan-tri.html#updatecontact">
				<!--Ten web-->
				<div class="input-group">
				<span class="input-group-addon">Số điện thoại</span>
				<input type="number" class="form-control" id="adminphone" name="adminphone" value="<?php echo $admin->GetCONTACT("phone"); ?>" placeholder="840123456" required="required">
				</div><br/>
				<!--Mota-->
				 <div class="input-group">
					<span class="input-group-addon">Email</span>
					<input type="email" class="form-control" id="adminemail" name="adminemail" value="<?php echo $admin->GetCONTACT("email"); ?>" placeholder="example@gmail.com" required="required">
				</div><br/>
				 <!--Dia chi-->
				  <div class="input-group">
					<span class="input-group-addon">Địa chỉ liên hệ:</span>
					<input type="text" class="form-control" id="adminadr" name="adminadr" value="<?php echo $admin->GetCONTACT("diachi"); ?>" placeholder="Ví dụ: Ba Dinh, Ha Noi" required="required">
				</div><br/>
				<!--POST-->	
					<div class="text-right">
					 <input type="submit" class="btn btn-success btn-sm" name="post_info" id="post_info" value="Lưu cấu hình"/>
					</div></form>
		  </div>

		</div>
	
		<!--Cai dat quang cao-->
		<div class="panel panel-custom">

		  <div class="panel-heading" id="ads_st">Cài đặt quảng cáo 1</div>

		  <div class="panel-body">
				<form method="POST" action="/trang-quan-tri.html#ads_st">
				<!--Ads1-->
				<div class="alert alert-info" role="alert">Quảng cáo chiều dài tự dộng x chiều rộng 250px.<br/>Ví trị hiển thị: Dưới thanh tìm kiếm trang chủ, dưới thông tin bài viết, trang cá nhân. </div>
				<div class="text-center"><p>Ảnh demo</p><img src="https://i.imgur.com/EY6bOlw.png"/></div>
				<br/>
				<div class="input-group">
				<span class="input-group-addon">Ảnh quảng cáo</span>
				<input type="url" class="form-control" id="ads_vuong" name="ads_vuong" value="<?php echo $admin->GetADS("ads1"); ?>" placeholder="Link quảng cáo ảnh chiều dài tự dộng x chiều rộng 250px (Bỏ trống tự ẩn ads)" >
				</div><br/>
				<div class="input-group">
				<span class="input-group-addon">Link đến</span>
				<input type="url" class="form-control" id="ads_vuong_link" name="ads_vuong_link" value="<?php echo $admin->GetADS("ads1_link"); ?>" placeholder="Link đến khi người dùng click vào" >
				</div><br/>
				<!--POST-->	
					<div class="text-right">
					 <input type="submit" class="btn btn-success btn-sm" name="post_ads_vuong" id="post_ads_vuong" value="Lưu cấu hình"/>
					</div></form>
		  </div>
		</div>
		<!--Cai dat quang cao-->
		<div class="panel panel-custom">

		  <div class="panel-heading" id="ads_st2">Cài đặt quảng cáo 2</div>

		  <div class="panel-body">
				<form method="POST" action="/trang-quan-tri.html#ads_st2">
				<!--Ads1-->
				<div class="alert alert-info" role="alert">Quảng cáo chiều dài tự dộng x chiều rộng 600px.<br/>Ví trị hiển thị: Dưới liên hệ trang chủ, dưới thông tin bài viết, trang tìm kiếm. </div>
				<div class="text-center"><p>Ảnh demo</p><img src="https://i.imgur.com/dYZDfFh.png"/></div>
				<br/>
				<div class="input-group">
				<span class="input-group-addon">Ảnh quảng cáo</span>
				<input type="url" class="form-control" id="ads_hcn" name="ads_hcn" value="<?php echo $admin->GetADS("ads2"); ?>" placeholder="Link quảng cáo ảnh chiều dài tự dộng x chiều rộng 600px (Bỏ trống tự ẩn ads)" >
				</div><br/>
				<div class="input-group">
				<span class="input-group-addon">Link đến</span>
				<input type="url" class="form-control" id="ads_hcn_link" name="ads_hcn_link" value="<?php echo $admin->GetADS("ads2_link"); ?>" placeholder="Link đến khi người dùng click vào" >
				</div><br/>
				<!--POST-->	
					<div class="text-right">
					 <input type="submit" class="btn btn-success btn-sm" name="post_ads_hcn" id="post_ads_hcn" value="Lưu cấu hình"/>
					</div></form>
		  </div>
		</div>
		<!--Cai dat quang cao-->
		<div class="panel panel-custom">

		  <div class="panel-heading" id="ads_st3">Cài đặt quảng cáo 3</div>

		  <div class="panel-body">
				<form method="POST" action="/trang-quan-tri.html#ads_st3">
				<!--Ads1-->
				<div class="alert alert-info" role="alert">Quảng cáo chiều dài tự dộng x chiều rộng 90px.<br/>Ví trị hiển thị: Đầu trang tìm kiếm, cuối trang bài viết, cuối trang đăng bài. </div>
				<div class="text-center"><p>Ảnh demo</p><img src="https://i.imgur.com/MX27NL6.png" width="100%"/></div>
				<br/>
				<div class="input-group">
				<span class="input-group-addon">Ảnh quảng cáo</span>
				<input type="url" class="form-control" id="ads_banner" name="ads_banner" value="<?php echo $admin->GetADS("ads3"); ?>" placeholder="Link quảng cáo ảnh chiều dài tự dộng x chiều rộng 90px (Bỏ trống tự ẩn ads)">
				</div><br/>
				<div class="input-group">
				<span class="input-group-addon">Link đến</span>
				<input type="url" class="form-control" id="ads_banner_link" name="ads_banner_link" value="<?php echo $admin->GetADS("ads3_link"); ?>" placeholder="Link đến khi người dùng click vào">
				</div><br/>
				<!--POST-->	
					<div class="text-right">
					 <input type="submit" class="btn btn-success btn-sm" name="post_ads_banner" id="post_ads_banner" value="Lưu cấu hình"/>
					</div></form>
		  </div>
		</div>
				
		</div>
<!--Vung can le phai-->

	<div class="page-header">

	  <h1><small>Cấu hình khác</small></h1>

	</div>
	<div class="col-md-5">
	   	<!--Thong ke-->
		<div class="panel panel-custom">

		  <div class="panel-heading" id="contact">Thống kê</div>

		  <div class="panel-body">
				<?php echo $admin->getThongKe(); ?>
		  </div>

		</div>
					<!--Phan quyen-->
					<div class="panel panel-custom">

					  <div class="panel-heading" id="phanquyen">Phân quyền kiểm duyệt</div>

					  <div class="panel-body">
							<form method="POST" action="/trang-quan-tri.html">
							<!--ID-->
							 <div class="input-group">
								<span class="input-group-addon">Email</span>
								<input type="text" class="form-control" id="email_pQ" name="email_pQ" value="" placeholder="Nhập email hoặc SĐT người kiểm duyệt"  required="required">
							</div><br/>
														<!--POST-->	
							<div class="text-right">
							 <input type="submit" class="btn btn-success btn-sm" name="post_kdv" id="post_kdv"  value="Thêm người kiểm duyệt"/>
							</div><br/>							</form>
							<!--KEY-->
							 <?php echo $admin->getKiemduyetvien(); ?>

							

					  </div>

					</div>
					<!--Phan quyen Admin-->
					<div class="panel panel-custom">

					  <div class="panel-heading" id="phanquyenAD">Phân quyền QTV</div>

					  <div class="panel-body">
							<form method="POST" action="/trang-quan-tri.html">
							<!--ID-->
							 <div class="input-group">
								<span class="input-group-addon">Email</span>
								<input type="text" class="form-control" id="email_QTV" name="email_QTV" value="" placeholder="Nhập email hoặc SĐT QTV"  required="required">
							</div><br/>
														<!--POST-->	
							<div class="text-right">
							 <input type="submit" class="btn btn-success btn-sm" name="post_qtv" id="post_qtv"  value="Thêm người quản trị viên"/>
							</div><br/>							</form>
							<!--KEY-->
							 <?php echo $admin->getQTV(); ?>

							

					  </div>

					</div>
					<!--CM-->
					<div class="panel panel-custom">

					  <div class="panel-heading" id="phanloai">Phân loại nông sản</div>

					  <div class="panel-body">
							<form method="POST" action="/trang-quan-tri.html">
							<select class="form-control" name="phanloaiNS" id="phanloaiNS">
								<?php
								require_once './inl/DB.php';
								$newDB = new DB();
								$newDB->showNongSan();
								?>
								</select><br/>
								<!--AddPL-->
							 <div class="input-group">
								<span class="input-group-addon">Tên nông sản</span>
								<input type="text" class="form-control" id="nongsan_add" name="nongsan_add" value="" placeholder="Ví dụ: Ớt, Tỏi,..." >
							</div><br/>
														<!--POST-->	
							<div class="text-right">
							 <input type="submit" class="btn btn-danger btn-sm" name="post_pl_xoa"  value="Xoá mục được chọn"/>
							 <input type="submit" class="btn btn-success btn-sm" name="post_pl_add"  value="Thêm mục phân loại"/>
							</div>						</form>
		

							

					  </div>

					</div>
					<!--Loc tu-->
					<div class="panel panel-custom">

					  <div class="panel-heading" id="boloc">Bộ lọc từ khoá - Cảnh báo người dùng trước khi đăng</div>

					  <div class="panel-body">
							<form method="POST" action="/trang-quan-tri.html">
							<select class="form-control" name="tukhoaxau" id="tukhoaxau">
								<?php
								require_once './inl/DB.php';
								$newDB = new DB();
								$newDB->showTuXau();
								?>
								</select><br/>
								<!--AddPL-->
							 <div class="input-group">
								<span class="input-group-addon">Thêm từ khoá</span>
								<input type="text" class="form-control" id="tukhoamoi" name="tukhoamoi" value="" >
							</div><br/>
														<!--POST-->	
							<div class="text-right">
							 <input type="submit" class="btn btn-danger btn-sm" name="xoaTK"  value="Xoá từ khoá đang chọn"/>
							 <input type="submit" class="btn btn-success btn-sm" name="themTK"  value="Thêm từ khoá"/>
							</div>						</form>
		

							

					  </div>

					</div>
								<!--FB-->
				<div class="panel panel-custom">

				  <div class="panel-heading" id="updateFB">Cài đặt App Facebook</div>

				  <div class="panel-body">
						<form method="POST" action="/trang-quan-tri.html#updateFB">
						<!--ID-->
						 <div class="input-group">
							<span class="input-group-addon">ID ứng dụng</span>
							<input type="text" class="form-control" id="idfb" name="idfb" value="<?php echo $getApp->GetAppID("facebook"); ?>"  required="required">
						</div><br/>
						<!--KEY-->
						 <div class="input-group">
							<span class="input-group-addon">Khoá bí mật</span>
							<input type="text" class="form-control" id="keyfb" name="keyfb" value="<?php echo $getApp->GetAppSecret("facebook"); ?>" placeholder="Khoá bị mật ứng dụng" required="required">
						</div><br/>
						<!--POST-->	
					<div class="text-right">
					 <input type="submit" class="btn btn-success btn-sm" name="post_facebook" value="Lưu cấu hình"/>
					</div></form>

				  </div>

				</div>
					<!--GG-->
					<div class="panel panel-custom">

					  <div class="panel-heading" id="updateGG">Cài đặt App Google</div>

					  <div class="panel-body">
								<form method="POST" action="/trang-quan-tri.html#updateGG">
							<!--ID-->
							 <div class="input-group">
								<span class="input-group-addon">Client ID</span>
								<input type="text" class="form-control" id="idgg" name="idgg" value="<?php echo $getApp->GetAppID("google"); ?>" required="required">
							</div><br/>
							<!--KEY-->
							 <div class="input-group">
								<span class="input-group-addon">Client secret</span>
								<input type="text" class="form-control" id="keygg" name="keygg" value="<?php echo $getApp->GetAppSecret("google"); ?>" placeholder="Khoá bị mật ứng dụng" required="required">
							</div><br/>
							<!--POST-->	
							<div class="text-right">
							 <input type="submit" class="btn btn-success btn-sm" name="post_google" value="Lưu cấu hình"/>
							</div>
							</form>
					  </div>

					</div>
					<!--ZL-->
					<div class="panel panel-custom">

					  <div class="panel-heading" id="updateZL">Cài đặt App Zalo</div>

					  <div class="panel-body">
							<form method="POST" action="/trang-quan-tri.html#updateZL">
							<!--ID-->
							 <div class="input-group">
								<span class="input-group-addon">ID ứng dụng</span>
								<input type="text" class="form-control" id="idzl" name="idzl" value="<?php echo $getApp->GetAppID("zalo"); ?>"  required="required">
							</div><br/>
							<!--KEY-->
							 <div class="input-group">
								<span class="input-group-addon">Khóa bí mật</span>
								<input type="text" class="form-control" id="keyzl" name="keyzl" value="<?php echo $getApp->GetAppSecret("zalo"); ?>" placeholder="Khoá bị mật ứng dụng" required="required">
							</div><br/>
							<!--POST-->	
							<div class="text-right">
							 <input type="submit" class="btn btn-success btn-sm" name="post_zalo"  value="Lưu cấu hình"/>
							</div>
							</form>
					  </div>

					</div>
		<!--end-->
	</div>
	</div>
</div>
<script type="text/javascript">
function clickDeletePermit(phuongthuc) {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		
	  if (this.readyState == 4 && this.status == 200) {
		window.location.replace("<?php echo $domain_home;?>trang-quan-tri.html");
	  }
	};
	xhttp.open("GET", "remove-kdv.php?method=" + phuongthuc, true);
	xhttp.send();
}
function clickTimMEM() {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		
	  if (this.readyState == 4 && this.status == 200) {
		  document.getElementById("caibangIF").innerHTML = this.responseText;
	  }
	};
	var tukhoa = document.getElementById("tv_tim").value;
	xhttp.open("GET", "tim-mem-ne?method=" + tukhoa, true);
	xhttp.send();
}
function clickDeleteMem(phuongthuc) {
		  var r = confirm("Bạn có chắc muốn xoá thành viên này?");
  if (r == true) {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		
	  if (this.readyState == 4 && this.status == 200) {
		window.location.replace("<?php echo $domain_home;?>trang-quan-tri.html");
	  }
	};
	xhttp.open("GET", "remove-mem.php?method=" + phuongthuc, true);
	xhttp.send();
}
}
</script>
</article>