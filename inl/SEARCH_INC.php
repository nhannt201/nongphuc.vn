<?php
/* Thiết kế và phát triển bởi Nguyễn Trung Nhẫn
*	Contact me: trungnhan0911@yandex.com
*	Github: https://github.com/nhannt201
*	Vui lòng không xoá những chú thích này để tôn trọng quyền tác giả
*/
	require_once './_config.php';	
class SEARCH {
	 
	function __construct(){
		if(!isset($this->db)){
			
			include( './_config.php');
			$conn = mysqli_connect($hostname, $username, $password,$database);
			if (!$conn) {
				die("CSDL máy chủ đang gặp lỗi: " . mysqli_connect_error());
			} else {
				 $this->db = $conn;
			}
			
			if (!$conn->set_charset("utf8")) { }

			date_default_timezone_set('Asia/Ho_Chi_Minh');

			if (date_default_timezone_get()) {
			  //  echo 'date_default_timezone_set: ' . date_default_timezone_get() . '';
			}
		}
	}

	function showThread($tinh_tp, $quan_huyen, $phuong_xa, $nongpham){
		$limit = 6; //gioi han hien thi KQ
		if (($nongpham == 0) and ($tinh_tp == 0)) {
			//Hien thi tat ca
			$check = $this->db->query("SELECT * FROM thread WHERE duyet='0' ORDER BY time DESC LIMIT $limit");
		} else if (($nongpham == 0) and ($phuong_xa == 0) and ($quan_huyen == 0)) {
			//Chi tim kiem theo tinh
			$check = $this->db->query("SELECT * FROM thread WHERE duyet='0' AND tinhtp='$tinh_tp' ORDER BY time DESC LIMIT $limit");
		}  else if (($tinh_tp == 0) and ($quan_huyen == 0) and ($phuong_xa == 0)) {
			//Khi chi chon nong san
			$check = $this->db->query("SELECT * FROM thread WHERE  phanloai='$nongpham' AND duyet='0' ORDER BY time DESC LIMIT $limit");
		} else if (($phuong_xa == 0) and ($nongpham == 0)) {
			//Tim kiem theo tinh, huyen
			$check = $this->db->query("SELECT * FROM thread WHERE tinhtp='$tinh_tp' AND quanhuyen='$quan_huyen' AND duyet='0' ORDER BY time DESC LIMIT $limit");
		} else if (($phuong_xa == 0) and ($quan_huyen == 0)) {
			//Tim kiem theo tinh va nong san
			$check = $this->db->query("SELECT * FROM thread WHERE tinhtp='$tinh_tp' AND phanloai='$nongpham' AND duyet='0' ORDER BY time DESC LIMIT $limit");
		} else {
			if ($nongpham == 0) {
				//Khi chon tinh, huyen, xa va nong san bo trong
				$check = $this->db->query("SELECT * FROM thread WHERE tinhtp='$tinh_tp' AND quanhuyen='$quan_huyen' AND xaphuong='$phuong_xa' AND duyet='0' ORDER BY time DESC LIMIT $limit");
			}else {
				//Khi chon tinh, huyen, xa va nong san
				$check = $this->db->query("SELECT * FROM thread WHERE tinhtp='$tinh_tp' AND quanhuyen='$quan_huyen' AND xaphuong='$phuong_xa' AND phanloai='$nongpham' AND duyet='0' ORDER BY time DESC LIMIT $limit");
			}
		}
		if (!$check) {echo '<div class="alert alert-warning" role="alert">Bài viết cho tìm kiếm này đang cập nhật. Vui lòng thử lại sao!</div>'; } else {
			if ($check->num_rows > 0) { // If Returned user .
			$dem = 0;
			$page = 1;
			$limit = 5;
				while($row = $check->fetch_assoc()) {
					//Lay thong tin nguoi dung
					$email_post = $row["email"];
					$gets = $this->db->query("SELECT * FROM member WHERE id='$email_post'"); //Bay gio ID ko con email nua
					if ($gets->num_rows > 0) 
						{ // If Returned user .
						$rows = $gets->fetch_assoc();
						$name = $rows['fullname'];
						//Xu li vi tri, dia chi
						$tinh =  $row["tinhtp"];	
						$huyen =  $row["quanhuyen"];
						$xa =  $row["xaphuong"];
						require_once './inl/LOCATION.php';
						$getAdr = new LOCATION();
						$vitri = $getAdr->getAddress($xa, $huyen, $tinh);
						//Xu li thoi gian
						$xuli_time = str_replace("=","h",date('H=i - d.m.Y', $row['time']));
						//$xuli_time = str_replace("+"," phút ",$xuli_time);
						//Xu li mo ta, gioi han ki tu hien thi theo space
						$mota_limit = (explode(" ",$row["mota"]));
						$mota = "";
						if (count($mota_limit) > 60) { 
							for ($x = 0; $x <= 60; $x++) {
								$mota .= $mota_limit[$x]." ";
							}
							$mota .= "...";
						} else {
							$mota = $row["mota"];
						}
						//Chuyen title sang urrl
						require_once './inl/VIEW.php';
						$view = new VIEW();
						//Bo dem de hien thi khi scroll, co JS ho tro
						if ($dem == $limit) {
							echo '<div id="show'.$page.'" style="display: none;">';
							$limit = $limit *2;
							$page++;
						}
						//In ra voi bai viet
						echo '<!--Bat dau 1 post-->
							<div class="list-group-item">
							<div class="row">
							<!--Cot trai-->
							<div class="col-md-3">
									<div class="text-center">
									  <img src="'. $row["img"].'" id="img_news" alt="'. $row["tengiong"].'">	
										<ul class="pager">	
											<li><a id="name_post">'. $row["tengiong"].'</a></li>
										</ul>		  
									  </div>	
							</div>
							<!--Cot phai-->
							<div class="col-md-9">
							<!--Panell-->
							<div class="panelCS panel-custom">

							  <div class="panel-heading"><span class="glyphicon glyphicon-flag"></span> Vị trí: '. $vitri.'</div>

							  <div class="panel-body">
							  '. $mota.'
							  </div>

							</div>
							<!--Endpanêl-->
							<!--Add-more-->	
											<p class="pull-left">Đăng bởi <b><i>'. $name.'</i></b><br/><b>'. $xuli_time.'</b></p>
												 <a href="/post/'.$view->textToURL($row["tengiong"])."_".$row["id"].'.html" class="btn btn-success pull-right" role="button">Xem chi tiết</a>
										<!--EndAdd-more-->
							</div>
							</div>
							</div>
							<!--End mot post--><br/>';
							if ($dem == $limit) {
							echo '<div/>';
												
								}
						}
						$dem++;
				}
				echo '<div class="alert alert-warning" role="alert">Bạn chỉ tìm kiếm được 6 kết quả. Vui lòng liên hệ admin để được cung cấp nhiều hơn!</div>';
				//In len dau trang
				echo ' <div id="go_top_mb"> <a href="#top_home" class="navbar-btn btn-success btn pull-right">
						  <span class="glyphicon glyphicon-arrow-up"></span> Lên đầu trang</a>
						</div>';
				//Ket thuc 
			
			} else {   //	 if no thread . 
				echo '<div class="alert alert-warning" role="alert">Bài viết cho tìm kiếm này đang cập nhật. Vui lòng thử lại sao!</div>';
			}
		}
	}
	//Tim kiem ko gioi han
	function showThreadPro($tinh_tp, $quan_huyen, $phuong_xa, $nongpham){
		$limit = 100000; //gioi han 100000 :))
		if (($nongpham == 0) and ($tinh_tp == 0)) {
			//Hien thi tat ca
			$check = $this->db->query("SELECT * FROM thread WHERE duyet='0' ORDER BY time DESC LIMIT $limit");
		} else if (($nongpham == 0) and ($phuong_xa == 0) and ($quan_huyen == 0)) {
			//Chi tim kiem theo tinh
			$check = $this->db->query("SELECT * FROM thread WHERE duyet='0' AND tinhtp='$tinh_tp' ORDER BY time DESC LIMIT $limit");
		}  else if (($tinh_tp == 0) and ($quan_huyen == 0) and ($phuong_xa == 0)) {
			//Khi chi chon nong san
			$check = $this->db->query("SELECT * FROM thread WHERE  phanloai='$nongpham' AND duyet='0' ORDER BY time DESC LIMIT $limit");
		} else if (($phuong_xa == 0) and ($nongpham == 0)) {
			//Tim kiem theo tinh, huyen
			$check = $this->db->query("SELECT * FROM thread WHERE tinhtp='$tinh_tp' AND quanhuyen='$quan_huyen' AND duyet='0' ORDER BY time DESC LIMIT $limit");
		} else if (($phuong_xa == 0) and ($quan_huyen == 0)) {
			//Tim kiem theo tinh va nong san
			$check = $this->db->query("SELECT * FROM thread WHERE tinhtp='$tinh_tp' AND phanloai='$nongpham' AND duyet='0' ORDER BY time DESC LIMIT $limit");
		} else {
			if ($nongpham == 0) {
				//Khi chon tinh, huyen, xa va nong san bo trong
				$check = $this->db->query("SELECT * FROM thread WHERE tinhtp='$tinh_tp' AND quanhuyen='$quan_huyen' AND xaphuong='$phuong_xa' AND duyet='0' ORDER BY time DESC LIMIT $limit");
			}else {
				//Khi chon tinh, huyen, xa va nong san
				$check = $this->db->query("SELECT * FROM thread WHERE tinhtp='$tinh_tp' AND quanhuyen='$quan_huyen' AND xaphuong='$phuong_xa' AND phanloai='$nongpham' AND duyet='0' ORDER BY time DESC LIMIT $limit");
			}
		}
		if (!$check) {echo '<div class="alert alert-warning" role="alert">Bài viết cho tìm kiếm này đang cập nhật. Vui lòng thử lại sao!</div>'; } else {
			if ($check->num_rows > 0) { // If Returned user .
			$dem = 0;
			$page = 1;
			$limit = 5;
				while($row = $check->fetch_assoc()) {
					//Lay thong tin nguoi dung
					$email_post = $row["email"];
					$gets = $this->db->query("SELECT * FROM member WHERE id='$email_post'"); //Bay gio ID ko con email nua
					if ($gets->num_rows > 0) 
						{ // If Returned user .
						$rows = $gets->fetch_assoc();
						$name = $rows['fullname'];
						//Xu li vi tri, dia chi
						$tinh =  $row["tinhtp"];	
						$huyen =  $row["quanhuyen"];
						$xa =  $row["xaphuong"];
						require_once './inl/LOCATION.php';
						$getAdr = new LOCATION();
						$vitri = $getAdr->getAddress($xa, $huyen, $tinh);
						//Xu li thoi gian
						$xuli_time = str_replace("=","h",date('H=i - d.m.Y', $row['time']));
						//$xuli_time = str_replace("+"," phút ",$xuli_time);
						//Xu li mo ta, gioi han ki tu hien thi theo space
						$mota_limit = (explode(" ",$row["mota"]));
						$mota = "";
						if (count($mota_limit) > 60) { 
							for ($x = 0; $x <= 60; $x++) {
								$mota .= $mota_limit[$x]." ";
							}
							$mota .= "...";
						} else {
							$mota = $row["mota"];
						}
						//Chuyen title sang urrl
						require_once './inl/VIEW.php';
						$view = new VIEW();
						//Bo dem de hien thi khi scroll, co JS ho tro
						if ($dem == $limit) {
							echo '<div id="show'.$page.'" style="display: none;">';
							$limit = $limit *2;
							$page++;
						}
						//In ra voi bai viet
						echo '<!--Bat dau 1 post-->
							<div class="list-group-item">
							<div class="row">
							<!--Cot trai-->
							<div class="col-md-3">
									<div class="text-center">
									  <img src="'. $row["img"].'" id="img_news" alt="'. $row["tengiong"].'">	
										<ul class="pager">	
											<li><a id="name_post">'. $row["tengiong"].'</a></li>
										</ul>		  
									  </div>	
							</div>
							<!--Cot phai-->
							<div class="col-md-9">
							<!--Panell-->
							<div class="panelCS panel-custom">

							  <div class="panel-heading"><span class="glyphicon glyphicon-flag"></span> Vị trí: '. $vitri.'</div>

							  <div class="panel-body">
							  '. $mota.'
							  </div>

							</div>
							<!--Endpanêl-->
							<!--Add-more-->	
											<p class="pull-left">Đăng bởi <b><i>'. $name.'</i></b><br/><b>'. $xuli_time.'</b></p>
												 <a href="/post/'.$view->textToURL($row["tengiong"])."_".$row["id"].'.html" class="btn btn-success pull-right" role="button">Xem chi tiết</a>
										<!--EndAdd-more-->
							</div>
							</div>
							</div>
							<!--End mot post--><br/>';
							if ($dem == $limit) {
							echo '<div/>';
												
								}
						}
						$dem++;
				}
				//In len dau trang
				echo ' <div id="go_top_mb"> <a href="#top_home" class="navbar-btn btn-success btn pull-right">
						  <span class="glyphicon glyphicon-arrow-up"></span> Lên đầu trang</a>
						</div>';
				//Ket thuc 
			
			} else {   //	 if no thread . 
				echo '<div class="alert alert-warning" role="alert">Bài viết cho tìm kiếm này đang cập nhật. Vui lòng thử lại sao!</div>';
			}
		}
	}
	//Tim kiem thanh vien
	function showMember($timkiem){
		$check = $this->db->query("SELECT * FROM member WHERE fullname LIKE '$timkiem%' OR email LIKE '$timkiem%' OR address LIKE '$timkiem%' OR phone LIKE '$timkiem%' LIMIT 10");
		if ($check->num_rows > 0) { 
		echo '<table class="table"><thead>
				  <tr>
					<th class="th-lg">Họ tên</th>
					<th class="th-lg">Email</th>
					<th class="th-lg">SĐT</th>
					<th class="th-lg">Địa chỉ</th>
					<th class="th-lg">Hành dộng</th>
				  </tr>
				</thead>
				<tbody>';
				while($row = $check->fetch_assoc()) {	
					if (empty($row['email'])) {
						$email = "(Trống)";
					} else {
						$email = $row['email'];
					}
					if (empty($row['phone'])) {
						$phone = "(Trống)";
					} else {
						$phone = $row['phone'];
					}
					if (empty($row['address'])) {
						$address = "(Trống)";
					} else {
						$address = $row['address'];
					}
					echo ' <tr>
							<td>'.$row['fullname'].'</td>
							<td>'.$email.'</td>
							<td>'.$phone.'</td>
							<td>'.$address.'</td>
							<td><span class="input-group-addon" onClick="clickDeleteMem('.$row['id'].')">Xoá</span></td>
						  </tr>';
				}
			echo '    	</tbody>
						</table>';
		} else {
			echo '<div class="alert alert-warning" role="alert">Không tìm thấy thành viên phù hợp!</div>';
		}
		}
		
		
	
	
}
?>