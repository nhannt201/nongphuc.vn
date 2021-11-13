<?php
/* Thiết kế và phát triển bởi Nguyễn Trung Nhẫn
*	Contact me: trungnhan0911@yandex.com
*	Github: https://github.com/nhannt201
*	Vui lòng không xoá những chú thích này để tôn trọng quyền tác giả
*/
	require_once './_config.php';	
class POST {
	 
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

	function showThread(){
		$check = $this->db->query("SELECT * FROM thread WHERE duyet='0' ORDER BY time DESC LIMIT 10");
			if ($check->num_rows > 0) { // If Returned user .
				while($row = $check->fetch_assoc()) {
					//Lay thong tin nguoi dung
					$email_post = $row["email"]; //Tu khi them SDT de dang nhap thi dung email de dat id, dung ID de lay thong tin MEMBER
					$gets = $this->db->query("SELECT * FROM member WHERE id='$email_post'"); //bay gio la ID chu k con la email nua, vi email k co dinh
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
						}
				 }
			} else {   //	 if no thread . 
				echo '<div class="alert alert-warning" role="alert">Hiện chưa có bài viết mới!</div>';
			}
	}
	
	//Khu xu li bai post moi
	function postNew($email, $xa, $huyen, $tinh, $phanloai, $otherphanloai, $tengiong, $mota, $img, $trong, $thuhoach, $toa_do, $pubon, $img1, $img2, $img3, $img4) {
		$time=time();
		if ($phanloai == 0) {
			if (strlen($otherphanloai) > 2) {
				//Giai thich: Neu nhu nguoi dung chon phan loai nong san moi thi se them o phan nay
				$query_pl = "INSERT INTO phanloai (name, duyet) VALUES ('$otherphanloai','1')";
				$this->db->query($query_pl);
				$gets = $this->db->query("SELECT * FROM phanloai WHERE name='$otherphanloai'");
					if ($gets->num_rows > 0) 
						{
						$rows = $gets->fetch_assoc();
						$phanloai = $rows['id'];
						}
			}
		} //1 nghia la chua duyet
		//Bay gio $email chinh la ID o bai viet
		require_once './inl/PROFILE.php';
		$getID = new PROFILE();
		$id_mem = $getID->GetMemberID($email);
		$query_it2 = "INSERT INTO thread (phanloai, tengiong, email, mota, img, tinhtp, quanhuyen, xaphuong, time, duyet, time_start, time_end, geolocation, showgeo, img1, img2, img3, img4) VALUES ('$phanloai','$tengiong', '$id_mem', '$mota', '$img', '$tinh', '$huyen', '$xa', '$time', '1', '$trong', '$thuhoach', '$toa_do', '$pubon', '$img1', '$img2', '$img3', '$img4')";
		$this->db->query($query_it2);
	}
	//Update bai viet
	function updatePOST( $xa, $huyen, $tinh, $phanloai, $otherphanloai, $tengiong, $mota, $img, $idphanloai, $idthread , $trong, $thuhoach, $toa_do, $pubon, $img1, $img2, $img3, $img4) {
		$time=time();
		if ($phanloai == 0) {
			if (strlen($otherphanloai) > 2) {
				//Giai thich: Neu nhu nguoi dung chon phan loai nong san moi thi se them o phan nay
				$query_pl = "UPDATE phanloai SET name='$otherphanloai' WHERE id='$idphanloai'";
				$this->db->query($query_pl);
				$phanloai = $idphanloai;
			}
		} else {
			require_once 'ADMIN.php';	
			$admin = new ADMIN();
			if (!$admin->getDuyetPhanloai($idphanloai)) {
				$query_it2 = "DELETE FROM phanloai WHERE id='$idphanloai'";
				$this->db->query($query_it2);
			}
		}
		//1 nghia la chua duyet
		$query_it2 = "UPDATE thread SET phanloai='$phanloai', tengiong='$tengiong', mota='$mota', img='$img', tinhtp='$tinh', quanhuyen='$huyen', xaphuong='$xa', time_edit='$time', duyet='1', ghichu='', time_start='$trong', time_end='$thuhoach', geolocation='$toa_do', showgeo='$pubon', img1='$img1', img2='$img2', img3='$img3', img4='$img4'  WHERE id='$idthread'";
		$this->db->query($query_it2);
	}
	//Hien thi cac bai viet cua ca nhan
	function showThreadNonPublic($email){
		//Bay gio $email chinh la ID o bai viet
		require_once './inl/PROFILE.php';
		$getID = new PROFILE();
		$id_mem = $getID->GetMemberID($email);
		//Email bay gio la ID MEMBER
		$check = $this->db->query("SELECT * FROM thread WHERE email='$id_mem' ORDER BY time DESC LIMIT 5");
			if ($check->num_rows > 0) { // If Returned user .
			$num = 0;
				while($row = $check->fetch_assoc()) {
					
					if ($row['duyet'] == 1) {
						echo ' <li class="list-group-item"><b>'.$row['tengiong'].'</b> (<a href="/sua-bai.html?id='.$row['id'].'"><span><i class="glyphicon glyphicon-edit"></i> Chỉnh sửa</span></a>)</li>';
						$num++;
					}
				 }
				 if ($num == 0) {
					 echo '<div class="alert alert-warning" role="alert">Hiện chưa có bài viết nào chờ duyệt!</div>';
				 }
			} else {   //	 if no thread . 
				echo '<div class="alert alert-warning" role="alert">Hiện chưa có bài viết nào chờ duyệt!</div>';
			}
	}
	function showThreadPublic($email){
		//Bay gio $email chinh la ID o bai viet
		require_once './inl/PROFILE.php';
		$getID = new PROFILE();
		$id_mem = $getID->GetMemberID($email);
		//Email bay gio la ID MEMBER
		$check = $this->db->query("SELECT * FROM thread WHERE email='$id_mem' ORDER BY time DESC LIMIT 5");
			if ($check->num_rows > 0) { // If Returned user .
			$num = 0;
				while($row = $check->fetch_assoc()) {
					
					if ($row['duyet'] == 0) {
						echo ' <li class="list-group-item"><b>'.$row['tengiong'].'</b> (<a href="/sua-bai.html?id='.$row['id'].'"><span><i class="glyphicon glyphicon-edit"></i> Chỉnh sửa</span></a>)</li>';
						$num++;
					}
				 }
				 if ($num == 0) {
					 echo '<div class="alert alert-warning" role="alert">Hiện chưa có bài viết nào được duyệt!</div>';
				 }
			} else {   //	 if no thread . 
				echo '<div class="alert alert-warning" role="alert">Hiện chưa có bài viết nào được duyệt!</div>';
			}
	}
	function showThreadWarming($email){
		//Bay gio $email chinh la ID o bai viet
		require_once './inl/PROFILE.php';
		$getID = new PROFILE();
		$id_mem = $getID->GetMemberID($email);
		//Email bay gio la ID MEMBER
		$check = $this->db->query("SELECT * FROM thread WHERE email='$id_mem' ORDER BY time DESC LIMIT 5");
			if ($check->num_rows > 0) { // If Returned user .
			$num = 0;
				while($row = $check->fetch_assoc()) {
					
					if ($row['duyet'] == 2) {
						echo ' <li class="list-group-item"><b>'.$row['tengiong'].'</b> (<a href="/sua-bai.html?id='.$row['id'].'"><span><i class="glyphicon glyphicon-edit"></i> Chỉnh sửa</span></a>)</li>';
						$num++;
					}
				 }
				 if ($num == 0) {
					 echo '<div class="alert alert-warning" role="alert">Bạn chưa bị nhắc nhở và cảnh báo.</div>';
				 }
			} else {   //	 if no thread . 
					 echo '<div class="alert alert-warning" role="alert">Bạn chưa bị nhắc nhở và cảnh báo.</div>';
			}
	}
	//Kiem tra co dang bai viet nao chua.
	function checkFirstThread($email){
		//Bay gio $email chinh la ID o bai viet
		require_once './inl/PROFILE.php';
		$getID = new PROFILE();
		$id_mem = $getID->GetMemberID($email);
		//Email bay gio la ID MEMBER
		$check = $this->db->query("SELECT * FROM thread WHERE email='$id_mem'");
			if ($check->num_rows > 0) { 
				return false;
			} else {   //	 if no thread . 
				return true;
			}
	}
	
	//Hien thi bai viet chinh sua
	function showEdit($email, $id, $muc){
		$check = $this->db->query("SELECT * FROM thread WHERE id='$id'");
			if ($check->num_rows > 0) { 
			$row = $check->fetch_assoc();
			//Lay ID tu Email de check
				//Bay gio $email chinh la ID o bai viet
				require_once './inl/PROFILE.php';
				$getID = new PROFILE();
				$id_mem = $getID->GetMemberID($email);
				//Email bay gio la ID MEMBER
				if ($id_mem == $row['email'] ) {
					switch ($muc) {
						case "tengiong":
							return $row['tengiong']; 
							break;
						case "phanloai":
							return $row['phanloai']; 
							break;
						case "mota":
							return $row['mota']; 
							break;
						case "img":
							return $row['img']; 
							break;
						case "img1":
							return $row['img1']; 
							break;
						case "img2":
							return $row['img2']; 
							break;
						case "img3":
							return $row['img3']; 
							break;
						case "img4":
							return $row['img4']; 
							break;
						case "tinhtp":
							return $row['tinhtp']; 
							break;
						case "quanhuyen":
							return $row['quanhuyen']; 
							break;
						case "xaphuong":
							return $row['xaphuong']; 
							break;
						case "ghichu":
							return $row['ghichu']; 
							break;
						case "email":
							return $row['email']; 
							break;
						case "time_start":
							return $row['time_start']; 
							break;
						case "time_end":
							return $row['time_end']; 
							break;
						case "toa_do":
							return $row['geolocation']; 
							break;
						case "public_loc":
							return $row['showgeo']; 
							break;
						default:
						return ""; 
					}
				}
			} else {
				return ""; 
			}
	}
	
}
?>