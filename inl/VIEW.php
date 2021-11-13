<?php
/* Thiết kế và phát triển bởi Nguyễn Trung Nhẫn
*	Contact me: trungnhan0911@yandex.com
*	Github: https://github.com/nhannt201
*	Vui lòng không xoá những chú thích này để tôn trọng quyền tác giả
*/
	require_once './_config.php';	
class VIEW {
 
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
			//Add guest
			if (isset($_SESSION['GUEST'])) {} else {$_SESSION['GUEST'] = 1; }
		}
	}
	//Check Thread 
	function checkThread($id){
		$check = $this->db->query("SELECT id, duyet FROM thread WHERE id='$id'");
			if ($check->num_rows > 0) { // If Returned user .
				$row = $check->fetch_assoc();
				if ($row['duyet'] == 0) {
					return true;
				} else {
				return false;
				}
			} else {
				return false;
			}
	}
	//Get Tacgia
	function getAuthor($id, $note){
		$check = $this->db->query("SELECT email, id FROM thread WHERE id='$id'");
			if ($check->num_rows > 0) { 
				$row = $check->fetch_assoc();
				$email = $row['email'];
				$check2 = $this->db->query("SELECT fullname, phone, address, email FROM member WHERE id='$email'"); //Bay gio ID ko con email nua
					if ($check2->num_rows > 0) { 
					$row2 = $check2->fetch_assoc();
					if ($note == "tacgia") {
						return $row2['fullname'];
					}
					if ($note == "phone") {
						return $row2['phone'];
					}
					if ($note == "email") {
						return $row2['email'];
					}
					if ($note == "diachi") {
						return $row2['address'];
					}
					if ($note == "about") {
						if(empty ($row2['aboutme'])) {
							return "(Không có)";
						} else {
							return $row2['aboutme'];
						}
					}
						
					} else {
						//Neu thanh vien bi xoa, chuyen bai viet ve cho Admin quan li
						$query_it1 = "UPDATE thread SET email='1' WHERE id='$id'";
						$this->db->query($query_it1);	
					}
		}
	}
	//GetHead
	function GetSEO($id, $note){
		$check = $this->db->query("SELECT * FROM thread WHERE id='$id'");
			if ($check->num_rows > 0) { 
				$row = $check->fetch_assoc();
				$email = $row['email'];
				//Kiem tra thoi gian
						if (empty($row["time_start"])) {
							$trong = "Đang cập nhật...";
						} else {
							$trong = $row["time_start"];
						}
						if (empty($row["time_end"])) {
							$thuhoach = "Đang cập nhật...";
						} else {
							$thuhoach = $row["time_end"];
						}
				$check2 = $this->db->query("SELECT fullname, phone, address, email FROM member WHERE id='$email'");//Bay gio ID ko con email nua
					if ($check2->num_rows > 0) { 
					$row2 = $check2->fetch_assoc();
					if ($note == "tacgia") {
						return $row2['fullname'];
					}
					if ($note == "trong") {
						return $trong;
					}
					if ($note == "thuhoach") {
						return $thuhoach;
					}
					if ($note == "phone") {
						return $row2['phone'];
					}
					if ($note == "diachi") {
						return $row2['address'];
					}
					if ($note == "tengiong") {
						return $row['tengiong'];
					}
					if ($note == "webname") {
						require_once './inl/ADMIN.php';  
						$getAD = new ADMIN();
						return $row['tengiong']." - ".$getAD->GetSEO("webname");
					}
					if ($note == "mota") {
						//Xu li mota
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
						return $mota;
					}
					if ($note == "image") {
						return $row['img'];
					}
					if ($note == "tukhoa") {
						require_once './inl/DB.php';
						$nameNS = new DB();
						return $row['tengiong'].", ".$nameNS->showNameNongSan($row['phanloai']);
					}
						//Xu li cua $row thread
						//Xu li thoi gian
						if ($note == "time") {
						return str_replace("=",":",date('H=i - d.m.Y', $row['time']));
						}
						if ($note == "time_mod") {
							if (empty($row['time_edit'])) {
								return str_replace("=",":",date('H=i - d.m.Y', $row['time']));
							} else {
								return str_replace("=",":",date('H=i - d.m.Y', $row['time_edit']));
							}
						
						}
						//Nhap DB de lay ten nong san.
						if ($note == "phanloai") {
						require_once './inl/DB.php';
						$nameNS = new DB();
						return $nameNS->showNameNongSan($row['phanloai']);
						}
						//Lay vi tri
						if ($note == "vitri") {
							//Xu li vi tri, dia chi
						$tinh =  $row["tinhtp"];	
						$huyen =  $row["quanhuyen"];
						$xa =  $row["xaphuong"];
						require_once './inl/LOCATION.php';
						$vitri = new LOCATION();
						return $vitri->getAddress($xa, $huyen, $tinh);
						}
						if ($note == "vitri_link") {
							//Xu li vi tri, dia chi
						$tinh =  $row["tinhtp"];	
						$huyen =  $row["quanhuyen"];
						$xa =  $row["xaphuong"];
						require_once './inl/LOCATION.php';
						$vitri = new LOCATION();
						$xuli_vitri = str_replace(" ","+",$vitri->getAddress($xa, $huyen, $tinh)); //Xu li de hien thi ra URL
						return $xuli_vitri;
						}
						if ($note == "toado") {
							if (empty($row['geolocation'])) {
								return false;
							} else {
							return $row['geolocation'];
							}
						}
					} 
		}
	}
	//Show Slide View
	function showSlideView($id){
		$check = $this->db->query("SELECT email, id FROM thread WHERE id='$id'");
			if ($check->num_rows > 0) { // If Returned user .
			$row = $check->fetch_assoc();
			$email = $row['email'];
			//Lay bai viet all
				$check2 = $this->db->query("SELECT * FROM thread WHERE email='$email' ORDER BY RAND () LIMIT 20");
				if ($check2->num_rows > 0) { // If Returned user .
				$num = 0;
					while($row2 = $check2->fetch_assoc()) {
						if ($row2['duyet'] == 0) {
							$mota_limit = (explode(" ",$row2["mota"]));
							$mota = "";
							if (count($mota_limit) > 30) { 
								for ($x = 0; $x <= 30; $x++) {
									$mota .= $mota_limit[$x]." ";
								}
								$mota .= "...";
							} else {
								$mota = $row2["mota"];
							}
							if ($num == 0) {
							echo '<div class="item active">
									<a href="/post/'.$this->textToURL($row2["tengiong"])."_".$row2["id"].'.html"><img src="'.$row2['img'].'" alt="'.$row2['tengiong'].'" style="width:100%;"></a>
									<div class="carousel-caption">
									  <h3>'.$row2['tengiong'].'</h3>
									  <p>'.$mota.'</p>
									</div>
								  </div>';
							} else {
								echo '<div class="item">
									<a href="/post/'.$this->textToURL($row2["tengiong"])."_".$row2["id"].'.html"><img src="'.$row2['img'].'" alt="'.$row2['tengiong'].'" style="width:100%;"></a>
									<div class="carousel-caption">
									  <h3>'.$row2['tengiong'].'</h3>
									  <p>'.$mota.'</p>
									</div>
								  </div>';
							}
							$num++;
						}	
					}
				}

			} else {   //	
				//No slide
			}
	}
	//Number Slide
	function showNumSlide($id){
		$check = $this->db->query("SELECT email, id FROM thread WHERE id='$id'");
			if ($check->num_rows > 0) { // If Returned user .
			$row = $check->fetch_assoc();
			$email = $row['email'];
			//Lay bai viet all
				$check2 = $this->db->query("SELECT email, duyet FROM thread WHERE email='$email' ORDER BY RAND () LIMIT 20"); //Email o day la ID
				if ($check2->num_rows > 0) { // If Returned user .
				$num = 0;
					while($row2 = $check2->fetch_assoc()) {
						if ($row2['duyet'] == 0) {
							if ($num ==0) {
								echo '<li data-target="#myCarousel" data-slide-to="0" class="active"></li>';
							} else {
								echo '
									<li data-target="#myCarousel" data-slide-to="'.$num.'"></li>';
							}
						$num++;
						}
							
						}	
					}
				}

			
	}
	//View Show ra nè
	function showThreadView($id){
		$check = $this->db->query("SELECT * FROM thread WHERE id='$id'");
			if ($check->num_rows > 0) { // If Returned user .
				$row = $check->fetch_assoc();
					//Lay thong tin nguoi dung
					$email_post = $row["email"];
					$gets = $this->db->query("SELECT * FROM member WHERE id='$email_post' "); //Bay gio ID ko con email nua
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
						$xuli_vitri = str_replace(" ","+",$vitri); //Xu li de hien thi ra URL
						//Cho phep chinh sua neu cung ID tai khoan
						$edit_allow = "";
						require_once './inl/PROFILE.php';
						$getID = new PROFILE();
						if (isset($_SESSION['EMAIL'])) { //Kiem tra email ton tai
							$email2 = $_SESSION['EMAIL'];
						}
						if (isset($_SESSION['PHONE'])) { //Kiem tra sdt ton tai
							$email2 = $_SESSION['PHONE'];
						}
						if (!empty($email2)) {
							$id_mem = $getID->GetMemberID($email2);
							if ($id_mem == $row['email']) {
								$edit_allow = ' <a href="/sua-bai.html?id='.$row['id'].'"><mark><span><i class="glyphicon glyphicon-edit"></i> Chỉnh sửa</span></mark></a>';
							}
						}

						//Xu li thoi gian
						$xuli_time = str_replace("=","h",date('H=i - d.m.Y', $row['time']));
						//$xuli_time = str_replace("+"," phút ",$xuli_time);
							$mota = $row["mota"];
						echo '<div class="panel panel-custom">	
								<div class="panel-heading">'.$row["tengiong"].''.$edit_allow.'</div>
							  <div class="panel-body">';
						//In ra voi bai viet
													echo '<div class="text-center"><img src="'.$row["img"].'" alt="'.$row["tengiong"].'" style="width: 60%; height: 20%;"/><p><br/><b>'.$row["tengiong"].'</b></p></div><br/>';

						echo '<div class="panelCS panel-custom">
							  <div class="panel-body">
							  '. $mota.'
							  </div>
							</div>';
							if (!empty($row['img1'])) {
								echo '<div class="text-center"><img src="'.$row["img1"].'" alt="'.$row["tengiong"].'" style="width: 60%; height: 20%;"/><p><br/><b>'.$row["tengiong"].'</b></p></div><br/>';
							}
							if (!empty($row['img2'])) {
								echo '<div class="text-center"><img src="'.$row["img2"].'" alt="'.$row["tengiong"].'" style="width: 60%; height: 20%;"/><p><br/><b>'.$row["tengiong"].'</b></p></div><br/>';
							}
							if (!empty($row['img3'])) {
								echo '<div class="text-center"><img src="'.$row["img3"].'" alt="'.$row["tengiong"].'" style="width: 60%; height: 20%;"/><p><br/><b>'.$row["tengiong"].'</b></p></div><br/>';
							}
							if (!empty($row['img4'])) {
								echo '<div class="text-center"><img src="'.$row["img4"].'" alt="'.$row["tengiong"].'" style="width: 60%; height: 20%;"/><p><br/><b>'.$row["tengiong"].'</b></p></div><br/>';
							}
						echo '<div class="panelCS panel-custom">
							  <div class="panel-body">
							  Bạn có thể tìm thấy <b>'.$row["tengiong"].'</b> tại <i><a href="https://www.google.com/maps/place/'. $xuli_vitri.'" target="_bank">'. $vitri.'</a></i>
							  </div>
							</div>';
							echo "</div></div>";
						}
			} else {   //	 if no thread . 
				//neu nhu khong co bai viet luon thi bla bla....
			}
	}
	//Lay Key and Bi mat cho App
	function textToURL($str) {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', trim($str));
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);
		$str = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $str);
		$str = str_replace(" ","-",$str);
        return strtolower($str);
    }

}
?>