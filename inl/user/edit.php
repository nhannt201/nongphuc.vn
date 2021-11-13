<?php
/* Thiết kế và phát triển bởi Nguyễn Trung Nhẫn
*	Contact me: trungnhan0911@yandex.com
*	Github: https://github.com/nhannt201
*	Vui lòng không xoá những chú thích này để tôn trọng quyền tác giả
*/
require_once './inl/POST.php';
require_once './inl/ADMIN.php';
require_once './inl/LOCATION.php';
$checkAD = new ADMIN();
$output = "";
$statuss = 1;
$post = new POST();
$loc = new LOCATION();
if (isset($_SESSION['EMAIL'])) { //Kiem tra email ton tai chua
	$email = $_SESSION['EMAIL'];
	if (isset($_GET['id'])) {
		$id_edit = trim($_GET['id']);
			//Bay gio $email chinh la ID o bai viet
				require_once './inl/PROFILE.php';
				$getID = new PROFILE();
				$id_mem = $getID->GetMemberID($email);
			if ($id_mem == $post->showEdit($email, $id_edit, "email") ) { 
				$idphanloai = $post->showEdit($email, $id_edit, "phanloai");
				if (!is_numeric($id_edit)) {
					echo '<script>window.location.replace("'.$domain_home.'");</script>';
					exit;
				}
			}	else {
				echo '<script>window.location.replace("'.$domain_home.'");</script>';
				exit;
			}
	}
} else {
	//Kiem tra neu nhu la SDT
		if (isset($_SESSION['PHONE'])) { //Kiem tra email ton tai chua
		$email = $_SESSION['PHONE'];
		if (isset($_GET['id'])) {
			$id_edit = trim($_GET['id']);
				//Bay gio $email chinh la ID o bai viet
					require_once './inl/PROFILE.php';
					$getID = new PROFILE();
					$id_mem = $getID->GetMemberID($email);
				if ($id_mem == $post->showEdit($email, $id_edit, "email") ) { //email o day bay gio la ID
					$idphanloai = $post->showEdit($email, $id_edit, "phanloai");
					if (!is_numeric($id_edit)) {
						echo '<script>window.location.replace("'.$domain_home.'");</script>';
						exit;
					}
				}	else {
					echo '<script>window.location.replace("'.$domain_home.'");</script>';
					exit;
				}
		}
		} else {
			echo '<script>window.location.replace("'.$domain_home.'");</script>';
			exit;
		}
}
if (isset($_POST['updatedata'])) {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	//Lay xu li va kiem tra xem da chon vi tri nong san hay chua
	$tinhtp = trim($_POST['tinh_tp']);
	//echo $tinhtp;
	if ($tinhtp == 0) {
			$output = '<div class="alert alert-warning" role="alert">Vui lòng chọn vị trí nông sản đầy đủ!</div>';
			$statuss = 0;
	}
	$quanhuyen = trim($_POST['quan_huyen']);
	//echo $quanhuyen;
	if ($quanhuyen == 0) {
			$output = '<div class="alert alert-warning" role="alert">Vui lòng chọn vị trí nông sản đầy đủ!</div>';
			$statuss = 0;
	}
	$phuongxa = trim($_POST['phuong_xa']);
	//echo $phuongxa;
	if ($phuongxa == 0) {
			$output = '<div class="alert alert-warning" role="alert">Vui lòng chọn vị trí nông sản đầy đủ!</div>';
			$statuss = 0;
	}
	$loaiNS = trim($_POST['nongpham']);
	$loaiNSO = trim(htmlspecialchars($_POST['nongpham_other'])); //ten nong san khac
	//Kiem tra xem neu chon nong pham khac
	if ($loaiNS == 0 ) { 
		if (strlen($loaiNSO) < 2) {
			$output = '<div class="alert alert-warning" role="alert">Vui lòng nhập <b>"Tên nông sản"</b> đầy đủ!</div>';
			$statuss = 0;
		}
	}
	$tengiong = trim(htmlspecialchars($_POST['tengiong']));
	$gioithieu = trim(htmlspecialchars($_POST['about_ns'])); //mo ta ve san pham
	//echo $quanhuyen;
	//Kiem tra dau vao
	if (strlen($gioithieu) < 10) {
		$output = '<div class="alert alert-warning" role="alert">Mô tả sản phẩm quá ngắn. Vui lòng thử lại!</div>';
		$statuss = 0;
	}
	//Kiem tra tu khoa an toan
	if (!$checkAD->CheckBlockWord($gioithieu)) {
		$output = '<div class="alert alert-warning" role="alert">Hệ thống nhận thấy bạn đang dùng các từ khoá nằm trong danh sách cấm. Vui lòng thử lại!</div>';
		$statuss = 0;
	}
	if (strlen($tengiong) < 5) {
		$output = '<div class="alert alert-warning" role="alert"><b>Tên giống</b> quá ngắn. Vui lòng thử lại!</div>';
		$statuss = 0;
	}
	//Khu upload file
	$file = $_FILES['anhSP']['tmp_name'];
	//Anh phu
	$file1 = $_FILES['anhSP1']['tmp_name'];
	$file2 = $_FILES['anhSP2']['tmp_name'];
	$file3 = $_FILES['anhSP3']['tmp_name'];
	$file4 = $_FILES['anhSP4']['tmp_name'];
					$img_path1 = "";
				$img_path2 = "";
				$img_path3 = "";
				$img_path4 = "";
	if (empty($file)) {
		$img_path = $post->showEdit($email, $id_edit, "img");
	} else {
	  $image_size = getimagesize($_FILES['anhSP']['tmp_name']);
	// Kiem tra dinh dang anh hop le
		if ($image_size==FALSE) {
		  $output = '<div class="alert alert-warning" role="alert">Bạn chỉ được tải lên các tệp ảnh jpg, png, jpeg và gif!</div>';
		  $uploadOk = 0;
		} else {
				//Tai anh len Imgur
				// $img_path = "https://vcdn-kinhdoanh.vnecdn.net/2019/06/05/xoai-1559725782-1559725802-1710-1559726344.png"; //link de tam de test
				if ($statuss == 1) {
					$handle = fopen($file1, "r");$data = fread($handle, filesize($file1));
				$imageData = base64_encode($data); // Read data, encode with base64 which Imgur API supported
				$pvars = array(
						  'image' => $imageData,
						  'type' => 'base64'
						);
				$timeout = 30; // Second
				$imgurClientID = "d523c802bc3c133"; // Imgur API key. Find in https://imgur.com/account/settings/apps

				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image');
				curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
				curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $imgurClientID));
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($curl, CURLOPT_POST, 1);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);

				$response = curl_exec($curl);
				curl_close($curl);

				$data = json_decode($response, true);
				$img_path = $data['data']['link'];
				//Ket thuc tai len Imgur
				}
		}
		
	}
	//Anh phu updatePOST
			//Bat dau tai len anh phu
	if (!empty($file1)) {
			   $image_size1 = getimagesize($_FILES['anhSP1']['tmp_name']);
		if ($image_size1==FALSE) {
		  $output = '<div class="alert alert-warning" role="alert">Bạn chỉ được tải lên các tệp ảnh jpg, png, jpeg và gif!</div>';
		  $uploadOk = 0;
		} else {
				if ($statuss == 1) {
				$handle = fopen($file1, "r");$data = fread($handle, filesize($file1));
				$imageData = base64_encode($data);$pvars = array('image' => $imageData,'type' => 'base64');$timeout = 30; $imgurClientID = "d523c802bc3c133"; 
				$curl = curl_init();curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image');curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $imgurClientID));curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);curl_setopt($curl, CURLOPT_POST, 1);curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);$response = curl_exec($curl);curl_close($curl);
				$data = json_decode($response, true);
				$img_path1 = $data['data']['link'];	
				//Ket thuc tai len Imgur
				}
		}
	} else {
		$img_path1 = $post->showEdit($email, $id_edit, "img1");
	}
	if (!empty($file2)) {
	   $image_size2 = getimagesize($_FILES['anhSP2']['tmp_name']);
				if ($image_size2==FALSE) {
		  $output = '<div class="alert alert-warning" role="alert">Bạn chỉ được tải lên các tệp ảnh jpg, png, jpeg và gif!</div>';
		  $uploadOk = 0;
		} else {
				if ($statuss == 1) {
				$handle = fopen($file2, "r");$data = fread($handle, filesize($file2));
				$imageData = base64_encode($data);$pvars = array('image' => $imageData,'type' => 'base64');$timeout = 30; $imgurClientID = "d523c802bc3c133"; 
				$curl = curl_init();curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image');curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $imgurClientID));curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);curl_setopt($curl, CURLOPT_POST, 1);curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);$response = curl_exec($curl);curl_close($curl);
				$data = json_decode($response, true);
				$img_path2 = $data['data']['link'];	
				//Ket thuc tai len Imgur
				}
		}
	} else {
		$img_path2 = $post->showEdit($email, $id_edit, "img2");
	}
	if (!empty($file3)) {
		$image_size3 = getimagesize($_FILES['anhSP3']['tmp_name']);
				if ($image_size3==FALSE) {
		  $output = '<div class="alert alert-warning" role="alert">Bạn chỉ được tải lên các tệp ảnh jpg, png, jpeg và gif!</div>';
		  $uploadOk = 0;
		} else {
				if ($statuss == 1) {
				$handle = fopen($file3, "r");$data = fread($handle, filesize($file3));
				$imageData = base64_encode($data);$pvars = array('image' => $imageData,'type' => 'base64');$timeout = 30; $imgurClientID = "d523c802bc3c133"; 
				$curl = curl_init();curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image');curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $imgurClientID));curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);curl_setopt($curl, CURLOPT_POST, 1);curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);$response = curl_exec($curl);curl_close($curl);
				$data = json_decode($response, true);
				$img_path3 = $data['data']['link'];	
				//Ket thuc tai len Imgur
				}
		}
	} else {
		$img_path3 = $post->showEdit($email, $id_edit, "img3");
	}
	if (!empty($file4)) {
		$image_size4 = getimagesize($_FILES['anhSP4']['tmp_name']);
				if ($image_size4==FALSE) {
		  $output = '<div class="alert alert-warning" role="alert">Bạn chỉ được tải lên các tệp ảnh jpg, png, jpeg và gif!</div>';
		  $uploadOk = 0;
		} else {
				if ($statuss == 1) {
				$handle = fopen($file4, "r");$data = fread($handle, filesize($file4));
				$imageData = base64_encode($data);$pvars = array('image' => $imageData,'type' => 'base64');$timeout = 30; $imgurClientID = "d523c802bc3c133"; 
				$curl = curl_init();curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image');curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $imgurClientID));curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);curl_setopt($curl, CURLOPT_POST, 1);curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);$response = curl_exec($curl);curl_close($curl);
				$data = json_decode($response, true);
				$img_path4 = $data['data']['link'];	
				//Ket thuc tai len Imgur
				}
		}
	} else {
		$img_path4 = $post->showEdit($email, $id_edit, "img4");
	}
	
	//Ket thuc tai anh phu
		//End anh phu
	//Them ngay trong va thu hoach
	$time_start = htmlspecialchars($_POST['time_trong']);
	$time_end = htmlspecialchars($_POST['time_thuhoach']);
	//if (!$profile->validateDate($time_start)) {  $statuss = 0;  $output = '<div class="alert alert-danger" role="alert">Ngày tháng năm trồng không hợp lệ!</div>'; }
	//if (!$profile->validateDate($time_end)) {  $statuss = 0; $output = '<div class="alert alert-danger" role="alert">Ngày tháng năm thu hoạch không hợp lệ!</div>'; }
	$toa_do = htmlspecialchars($_POST['vitri_geolocation']);
	$pub_on = trim(htmlspecialchars($_POST['public_loc']));
	//Update data
	if ($statuss == 1) {
		$post->updatePOST($phuongxa, $quanhuyen, $tinhtp, $loaiNS, $loaiNSO, $tengiong, $gioithieu, $img_path, $idphanloai, $id_edit, $time_start, $time_end, $toa_do, $pub_on, $img_path1, $img_path2, $img_path3, $img_path4);
		$output = '<div class="alert alert-success" role="alert">Bài viết đã đươc cập nhật và đang chờ duyêt!</div>';
	}
	}
}
?>
<article class="container">
<div class="row">
<div class="col-md-8">
<!--Nam vao vung can le trai-->
<!--<div class="canbang_form">-->
<div class="page-header">

  <h1>Chỉnh sửa bài viết cũ</h1>

</div>
<!--Profile-->
<div class="panel panel-custom">

  <div class="panel-heading">Chỉnh sửa bài viết</div>

  <div class="panel-body">

	<div class="panel-body">
	 <form id="frm_update" method="POST" action="/sua-bai.html?id=<?php echo $id_edit; ?>" enctype="multipart/form-data">
	    <div id="baoloi"><?php echo $output; ?></div>
	 	<!--Vi tri-->
		<div class="panel panel-custom">
		<div class="panel-heading">Chọn vị trí nông sản của bạn</div>
		 <div class="panel-body">
				<select class="form-control" name="tinh_tp" id="tinh_tp" onchange="clickProvince()" required="required">
				<option value="0">--Tỉnh/Thành phố--</option>
				<?php
				require_once './inl/DB.php';
				$newDB = new DB();
				$newDB->showProvince();
				?>
				<?php echo '<option value="'.$post->showEdit($email, $id_edit, "tinhtp").'" selected>'.$loc->getTinh($post->showEdit($email, $id_edit, "tinhtp")).'</option>'; ?>
				</select><br/>
				<select class="form-control" name="quan_huyen" id="quan_huyen" onchange="clickDistrict()" required="required">
				<?php echo '<option value="'.$post->showEdit($email, $id_edit, "quanhuyen").'" selected>'.$loc->getHuyen($post->showEdit($email, $id_edit, "quanhuyen")).'</option>'; ?>
				</select><br/>
				<select class="form-control" name="phuong_xa" id="phuong_xa">
				<?php echo '<option value="'.$post->showEdit($email, $id_edit, "xaphuong").'" selected>'.$loc->getXa($post->showEdit($email, $id_edit, "xaphuong")).'</option>'; ?>
				</select><br/>
				<!--Dinh vi noi tong-->
				<div class="input-group">
					<span class="input-group-addon" onclick="getLocation()">Bấm để định vị</span>
					<input type="text" class="form-control" id="vitri_geolocation" onclick="getLocation()" name="vitri_geolocation" value="<?php echo $post->showEdit($email, $id_edit, "toa_do"); ?>" readonly placeholder="Toạ độ của bạn">
				</div><br/>
				<!--Tuy chon hien thi-->
						<div class="input-group">
					<span class="input-group-addon">Hiển thị toạ độ:</span>
						<select class="form-control" name="public_loc" id="public_loc">
						<?php if ( $post->showEdit($email, $id_edit, "public_loc") == 0 ) {
							echo '<option value="0" selected>Công khai</option>';
							echo '	<option value="1" >Riêng tư</option>';
						} else {
							echo '<option value="0" >Công khai</option>';
							echo '	<option value="1" selected>Riêng tư</option>';
						}?>
						</select></div><br/>
					<div id="mapholder"></div>
					<script src="https://maps.google.com/maps/api/js?key="></script>
			</div></div>
			<script><!--geoLOC-->
				var x = document.getElementById("baoloi");
				var y = document.getElementById("vitri_geolocation");
				function getLocation() {
				  if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(showPosition, showError);
				  } else { 
					x.innerHTML = '<div class="alert alert-danger" role="alert">Định vị địa lý không được hỗ trợ bởi trình duyệt này.</div>';
				  }
				}

				function showPosition(position) {
				  y.value =  position.coords.latitude + " " + position.coords.longitude;
							var lat=position.coords.latitude;
						  var lon=position.coords.longitude;
						  var latlon=new google.maps.LatLng(lat, lon)
						  var mapholder=document.getElementById('mapholder')
						  mapholder.style.height='250px';
						  mapholder.style.width='100%';
							mapholder.innerHTML = '<iframe src="https://www.google.com/maps/embed/v1/place?key=&q='+ lat+ "+" + lon + '" height="250px" width="100%" frameborder="0"/>';

				}

				function showError(error) {
				  switch(error.code) {
					case error.PERMISSION_DENIED:
					  x.innerHTML = '<div class="alert alert-danger" role="alert">Bạn đã từ chối yêu cầu Định vị địa lý.</div>'
					  break;
					case error.POSITION_UNAVAILABLE:
					  x.innerHTML = '<div class="alert alert-danger" role="alert">Thông tin vị trí không có sẵn.</div>'
					  break;
					case error.TIMEOUT:
					  x.innerHTML = '<div class="alert alert-danger" role="alert">Yêu cầu để có được vị trí người dùng đã hết thời gian.</div>'
					  break;
					case error.UNKNOWN_ERROR:
					  x.innerHTML = '<div class="alert alert-danger" role="alert">Một lỗi không xác định đã xảy ra.</div>'
					  break;
				  }
				}
				</script>
		<!--Chon loai nong san-->
			<div class="panel panel-custom">
		<div class="panel-heading">Thông tin chi tiết nông sản</div>
		 <div class="panel-body">
		<div class="input-group">
		<span class="input-group-addon">Loại nông sản</span>
			<select class="form-control" name="nongpham" id="nongpham" onchange="clickOther()" required="required">
			<option value="0" >Khác</option>
			<?php
			require_once './inl/DB.php';
			$newDB = new DB();
			$newDB->showNongSan();	
			if ($admin->getDuyetPhanloai($idphanloai)) {
				echo '<option value="'.$idphanloai.'" selected>'.$newDB->showNameNongSan($idphanloai).'</option>';
			}
			?>
			</select></div><br/>
			<script type="text/javascript">
			function clickOther() {
				var xyz = document.getElementById("nongpham").selectedIndex;
				var xx = document.getElementById("othernongsan");
				//var valuee = document.getElementsByTagName("option")[xyz].value;
				//alert(xyz);
				if (xyz == "0") {
					
					if (xx.style.display === "none") {
						xx.style.display = "block";
					} else {
						xx.style.display = "none";
					}
				} else {
					xx.style.display = "none";
				}

			}
			</script>
		<!--Neu khong co, tu them vao-->
		<?php if ($admin->getDuyetPhanloai($idphanloai)): ?>
		<div id="othernongsan" name="othernongsan" style=" display: none;">
		<?php else: ?>
		<div id="othernongsan" name="othernongsan" style=" display: block;">
		<?php endif ?>
		<div class="alert alert-warning" role="alert">Lưu ý: Chỉ nhập <b>"Tên nông sản"</b> khi nông sản của bạn không có trong <b>"Loại nông sản"</b></div>
		<div class="input-group">
		<span class="input-group-addon">Tên nông sản</span>
		<?php if (!$admin->getDuyetPhanloai($idphanloai)): ?>
		<input type="text" class="form-control" id="nongpham_other" name="nongpham_other" value="<?php echo $newDB->showNameNongSan($idphanloai); ?>" placeholder="Ví dụ: Ớt, Giềng, ...">
		<?php else: ?>
		<input type="text" class="form-control" id="nongpham_other" name="nongpham_other" value="" placeholder="Ví dụ: Ớt, Giềng, ...">
		<?php endif ?>
		</div><br/></div>
		<!--Ten giong-->
		<div class="input-group">
		<span class="input-group-addon">Tên giống</span>
		<input type="text" class="form-control" id="tengiong" name="tengiong" value="<?php echo $post->showEdit($email, $id_edit, "tengiong"); ?>" placeholder="Ví dụ: Xoài cát Hoà Lộc" required="required">
		</div><br/>
		<!--Mota-->
		 <label>Mô tả:</label>
		   <div class="form-group">
			<textarea class="form-control" id="about_ns" name="about_ns" rows="3"><?php echo $post->showEdit($email, $id_edit, "mota"); ?></textarea>
		  </div>
		<!--AnhSP-->
			<!--<div class="input-group">
			  <span class="input-group-addon">Ảnh nông sản</span>
			  <input type="file" id="anhSP"  name="anhSP" class="form-control">		
			</div></br>-->
			<div class="input-group">
			 <label>Ảnh nông sản: (bắt buộc)</label>	
				<div class="custom-file mb-3">
				  <input type="file" class="custom-file-input" id="anhSP" name="anhSP">
				  <label class="custom-file-label" for="customFile"><span class="glyphicon glyphicon-camera"></span> Chọn ảnh nổi bật</label>
				</div>
				<div class="text-center"> <img id="img_news" src="<?php echo $post->showEdit($email, $id_edit, "img"); ?>"/></div>
			 <label>Thêm ảnh: (không bắt buộc)</label>
			 <!--Anh1--->
			 <div class="custom-file mb-3">
				  <input type="file" class="custom-file-input" id="anhSP1" name="anhSP1">
				  <label class="custom-file-label" for="customFile"><span class="glyphicon glyphicon-camera"></span> Chọn ảnh 1</label>
				</div>
				<?php if ($post->showEdit($email, $id_edit, "img1")) {?>
			<div class="text-center"> <img id="img_news" src="<?php echo $post->showEdit($email, $id_edit, "img1"); ?>"/></div>
				<?php } ?>
			<!--Anh2--->
			 <div class="custom-file mb-3">
				  <input type="file" class="custom-file-input" id="anhSP2" name="anhSP2">
				  <label class="custom-file-label" for="customFile"><span class="glyphicon glyphicon-camera"></span> Chọn ảnh 2</label>
				</div>
								<?php if ($post->showEdit($email, $id_edit, "img2")) {?>
			<div class="text-center"> <img id="img_news" src="<?php echo $post->showEdit($email, $id_edit, "img2"); ?>"/></div>
				<?php } ?>
			<!--Anh3--->
			 <div class="custom-file mb-3">
				  <input type="file" class="custom-file-input" id="anhSP3" name="anhSP3">
				  <label class="custom-file-label" for="customFile"><span class="glyphicon glyphicon-camera"></span> Chọn ảnh 3</label>
				</div>
								<?php if ($post->showEdit($email, $id_edit, "img3")) {?>
			<div class="text-center"> <img id="img_news" src="<?php echo $post->showEdit($email, $id_edit, "img3"); ?>"/></div>
				<?php } ?>
			<!--Anh4--->
			 <div class="custom-file mb-3">
				  <input type="file" class="custom-file-input" id="anhSP4" name="anhSP4">
				  <label class="custom-file-label" for="customFile"><span class="glyphicon glyphicon-camera"></span> Chọn ảnh 4</label>
				</div>
			</div>
							<?php if ($post->showEdit($email, $id_edit, "img4")) {?>
			<div class="text-center"> <img id="img_news" src="<?php echo $post->showEdit($email, $id_edit, "img4"); ?>"/></div>
				<?php } ?>
			</br>
	<style><!--Bootrap 4.5-->
	.custom-file-input.is-valid~.custom-file-label,.was-validated .custom-file-input:valid~.custom-file-label{border-color:#28a745}.custom-file-input.is-valid:focus~.custom-file-label,.was-validated .custom-file-input:valid:focus~.custom-file-label{border-color:#28a745;box-shadow:0 0 0 .2rem rgba(40,167,69,.25)}
	.custom-file-input.is-invalid~.custom-file-label,.was-validated .custom-file-input:invalid~.custom-file-label{border-color:#dc3545}.custom-file-input.is-invalid:focus~.custom-file-label,.was-validated .custom-file-input:invalid:focus~.custom-file-label{border-color:#dc3545;box-shadow:0 0 0 .2rem rgba(220,53,69,.25)}
	.custom-file{position:relative;display:inline-block;width:100%;height:calc(1.5em + .75rem + 2px);margin-bottom:0}.custom-file-input{position:relative;z-index:2;width:100%;height:calc(1.5em + .75rem + 2px);margin:0;opacity:0}.custom-file-input:focus~.custom-file-label{border-color:#80bdff;box-shadow:0 0 0 .2rem rgba(0,123,255,.25)}.custom-file-input:disabled~.custom-file-label,.custom-file-input[disabled]~.custom-file-label{background-color:#e9ecef}.custom-file-input:lang(vi)~.custom-file-label::after{content:"Duyệt file"}.custom-file-input~.custom-file-label[data-browse]::after{content:attr(data-browse)}.custom-file-label{position:absolute;top:0;right:0;left:0;z-index:1;height:calc(1.5em + .75rem + 2px);padding:.375rem .75rem;font-weight:400;line-height:1.5;color:#495057;background-color:#fff;border:1px solid #ced4da;border-radius:.25rem}.custom-file-label::after{position:absolute;top:0;right:0;bottom:0;z-index:3;display:block;height:calc(1.5em + .75rem);padding:.375rem .75rem;line-height:1.5;color:#495057;content:"Duyệt file";background-color:#e9ecef;border-left:inherit;border-radius:0 .25rem .25rem 0}.custom-range{width:100%;height:1.4rem;padding:0;background-color:transparent;-webkit-appearance:none;-moz-appearance:none;appearance:none}
	.custom-file-label,.custom-select{transition:background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out}@media (prefers-reduced-motion:reduce){.custom-control-label::before,.custom-file-label,.custom-select{transition:none}}
	</style>
		<script>
	// the file appear on select
	$(".custom-file-input").on("change", function() {
	  var fileName = $(this).val().split("\\").pop();
	  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
	});
	</script>
			
			<!--
			   <script type="text/javascript">
			       function readURL(input) {
					if (input.files && input.files[0]) {
						var reader = new FileReader();
						
						reader.onload = function (e) {
							$('#img_news').attr('src', e.target.result);
						}
						
						reader.readAsDataURL(input.files[0]);
					}
				}
				
				$("#anhSP").change(function(){
					readURL(this);
				});
			   </script>-->
			   	<!--Trong-->
				 <label for="sel1">Thời gian trồng:</label>
				 <!-- Datepicker as text field -->         
				  <div class="input-group date" data-date-format="dd.mm.yyyy">
					<input  type="text" id="time_trong" name="time_trong" value="<?php echo $post->showEdit($email, $id_edit, "time_start"); ?>" class="form-control" placeholder="ngày.tháng.năm trồng hoặc xuống giống (Bỏ trống nếu không nhớ)">
					<div class="input-group-addon" >
					  <span class="glyphicon glyphicon-th"></span> Lịch
					</div>
				  </div>
				  		<!--ThuHoach-->
				 <label for="sel2">Thời gian thu hoạch:</label>
				 <!-- Datepicker as text field -->         
				  <div class="input-group date" data-date-format="dd.mm.yyyy">
					<input  type="text" id="time_thuhoach" name="time_thuhoach" value="<?php echo $post->showEdit($email, $id_edit, "time_end"); ?>" class="form-control" placeholder="ngày.tháng.năm thu hoạch (Bỏ trống nếu không nhớ)">
					<div class="input-group-addon" >
					  <span class="glyphicon glyphicon-th"></span> Lịch
					</div>
				  </div>
				<script id="rendered-js">
				$('.input-group.date').datepicker({ format: "dd.mm.yyyy" });
					</script><br/>
		</div></div>
		<!--POST-->	
			<div class="text-right">
			 <input type="submit" class="btn btn-success btn-sm" name="updatedata" id="updatedata" value="Cập nhật bài viết"/>
			</div>
				</div>
		</div>
	</form>
  <!--JS_XL-->
 <script type="text/javascript" src="/js/jquery.qq.js"></script>
  </div>
<?php  require_once './inl/ADS.php';
		$getADS = new ADS();if ($getADS->GetADS("ads3")): ?>
		<!--Panel Ads Hoz-->
		<div class="panel panel-default" id="ads-right">
		<a rel="nofollow"  href="<?php echo $getADS->GetADS("ads3_link"); ?>" target="_blank"><img src="<?php echo $getADS->GetADS("ads3"); ?>" width="100%"/></a>
		</div>
		<?php endif ?>
</div>
<!--Vung can le phai-->
	<div class="page-header">

	  <h1><small>Bài viết gần đây</small></h1>

	</div>
	<div class="col-md-4">
	<!--Ghichu-->
	<?php $ghichu = $post->showEdit($email, $id_edit, "ghichu");
	if (empty($ghichu)) {} else {
	?>
		<div class="panel panel-custom">

		  <div class="panel-heading" >Bạn có ghi chú cho bài viết này</div>

		  <div class="panel-body">

		  <ul class="list-group">
		<?php echo '<div class="alert alert-danger" role="alert">'.$ghichu.'</div>'; ?>
			</ul>

		  </div>

		</div>
	<?php } ?>
			<!--Bicam-->
		<div class="panel panel-custom">

		  <div class="panel-heading" >Bài viết bị cảnh báo</div>

		  <div class="panel-body">

		  <ul class="list-group">
		<?php $post->showThreadWarming($email); ?>
			</ul>

		  </div>

		</div>
		<!--ChoD-->
		<div class="panel panel-custom">

		  <div class="panel-heading" >Đang chờ duyệt</div>

		  <div class="panel-body">
			<ul class="list-group">
		<?php $post->showThreadNonPublic($email); ?>
			</ul>
		  </div>

		</div>
		<!--daduyet-->
		<div class="panel panel-custom">

		  <div class="panel-heading" >Đã duyệt</div>

		  <div class="panel-body">

		  <ul class="list-group">
		<?php $post->showThreadPublic($email); ?>
			</ul>

		  </div>

		</div>
		
		<!--end-->
	</div>
	</div>
</div>
</article>
