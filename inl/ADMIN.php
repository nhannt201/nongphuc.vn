<?php
/* Thiết kế và phát triển bởi Nguyễn Trung Nhẫn
*	Contact me: trungnhan0911@yandex.com
*	Github: https://github.com/nhannt201
*	Vui lòng không xoá những chú thích này để tôn trọng quyền tác giả
*/
	require_once './_config.php';	
class ADMIN {
	 
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

	//Chan tu khoa xấu
	function CheckBlockWord($content){
		$check = $this->db->query("SELECT * FROM blockwords");
			if ($check->num_rows > 0) { 
				$khong_an_toan = 0;
				while($row = $check->fetch_assoc()) {
					if (strpos(strtolower($content), strtolower(trim($row['word']))) !== false) {
						$khong_an_toan++;
					}
				 }
				 if ($khong_an_toan > 0) {
					 return false;
				 } else {
					 return true;
				 }

			} else {   //	 if emppty in DB . 
				return true;
			}
	}
	//Thong ke 
	function getThongKe(){
		$check = $this->db->query("SELECT * FROM thread");
		$check2 = $this->db->query("SELECT * FROM member");
			if ($check->num_rows > 0) { 
				$dem = 0;
				$duyetr = 0;
				$choduyet = 0;
				$camm = 0;
				while($row = $check->fetch_assoc()) {
					if ($row['duyet'] == 0) {
						$duyetr++;
					}
					if ($row['duyet'] == 1) {
						$choduyet++;
					}
					if ($row['duyet'] == 2) {
						$camm++;
					}
					$dem++;
				 }
			echo '<div class="alert alert-info" role="alert">Bài viết: <b>'.$dem.'</b> (Đã duyệt <b>'.$duyetr.'</b>, chưa duyệt <b>'.$choduyet.'</b> và bị cảnh báo <b>'.$camm.'</b>)</div>';
			
			} else {   //
				echo '<div class="alert alert-info" role="alert">Bài viết: <b>0</b></div>';
			}
						if ($check->num_rows > 0) { 
					$dem2 = 0;
					while($row2 = $check2->fetch_assoc()) {
						$dem2++;
					 }
					echo '<div class="alert alert-info" role="alert">Thành viên: <b>'.$dem2.'</b></div>';
			} else {
					echo '<div class="alert alert-info" role="alert">Thành viên: <b>0</b></div>';
			}
	}
	//Get nguoi kiem duyet
	function getKiemduyetvien(){
		$check = $this->db->query("SELECT * FROM admin WHERE quyen='1'");
			if ($check->num_rows > 0) { 
				while($row = $check->fetch_assoc()) {			
				require_once './inl/PROFILE.php';
				$getID = new PROFILE();
				$mailOrPhone = $getID->GetEmailorPhoneID($row['email']); //lay email va phone tu ID member
				//Email bay gio la ID MEMBER				
					echo ' <div class="input-group">
								<span class="input-group-addon">Kiểm duyệt viên</span>
								<input type="text" class="form-control" value="'.$mailOrPhone.'" readonly="">
								<span class="input-group-addon" onClick="clickDeletePermit('.$row['id'].')">Xoá</span>
							</div><br/>';
				}
			}  else {
				echo ' <div class="input-group">
								<span class="input-group-addon">Kiểm duyệt viên</span>
								<input type="text" class="form-control" value="Bạn chưa thêm ai!" readonly="">

							</div><br/>';
			}
	}
	//Get thanh vien
	function getThanhVien(){
		$check = $this->db->query("SELECT id,fullname, address, email, phone, sex FROM member ORDER BY id DESC LIMIT 10");
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
			}  else {
				echo ' ';
			}
	}
	//Xoa kiem duyet vien va QTV
	function XoaKDV($id){
					$query_it2 = "DELETE FROM admin WHERE id='$id'";
					$this->db->query($query_it2);												
	}
	function XoaMEM($id){
					$query_it2 = "DELETE FROM member WHERE id='$id'";
					$this->db->query($query_it2);												
	}
	//ThemKDV
	function AddKDV($email) {
		//Check tk co ton tai chua
		//Them kiem tra số nếu người dùng sđt
		if (is_numeric($email)) {
		$check2 = $this->db->query("SELECT * FROM member WHERE phone='$email'");
		} else {
		$check2 = $this->db->query("SELECT * FROM member WHERE email='$email'");
		}
			if ($check2->num_rows > 0) {
				//Lay ID tu Email
					//Bay gio $email chinh la ID o bai viet
					require_once './inl/PROFILE.php';
					$getID = new PROFILE();
					$id_mem = $getID->GetMemberID($email);
					//Email bay gio la ID MEMBER
				$check = $this->db->query("SELECT * FROM admin WHERE email='$id_mem'");
					if ($check->num_rows > 0) 
					{ 
						//$row = $check->fetch_assoc();
					//	if ($row['duyet'] == 1) {
							return false;
						//} else if ($row['duyet'] == 0) {
					//		return false;
						//} else {
					//		$query_it2 = "INSERT INTO admin (email, quyen) VALUES ('$email', '1')";
					//		$this->db->query($query_it2);
					//		return true;
						//}
						
					} else {
						//Neu la sdt ti cho vao muc email luon, khoi phai edit CSDL
						$query_it2 = "INSERT INTO admin (email, quyen) VALUES ('$id_mem', '1')"; //email o day chinh la ID
						$this->db->query($query_it2);
						return true;
					}
			} else {
				return false;
			}
	}
	//Get nguoi QTV
	function getQTV(){
		$check = $this->db->query("SELECT * FROM admin WHERE quyen='0'");
			if ($check->num_rows > 0) { 
				while($row = $check->fetch_assoc()) {			
				require_once './inl/PROFILE.php';
				$getID = new PROFILE();
				$mailOrPhone = $getID->GetEmailorPhoneID($row['email']); //lay email va phone tu ID member
				//Email bay gio la ID MEMBER				
					echo ' <div class="input-group">
								<span class="input-group-addon">Quản trị viên</span>
								<input type="text" class="form-control" value="'.$mailOrPhone.'" readonly="">
								<span class="input-group-addon" onClick="clickDeletePermit('.$row['id'].')">Xoá</span>
							</div><br/>';
				}
			}  else {
				echo ' <div class="input-group">
								<span class="input-group-addon">Quản trị viên</span>
								<input type="text" class="form-control" value="Bạn chưa thêm ai!" readonly="">

							</div><br/>';
			}
	}
	//Xoa QTV
//	function XoaQTV($id){
	//				$query_it2 = "DELETE FROM admin WHERE id='$id'";
	//				$this->db->query($query_it2);												
	//}
	//Them QTV
	function AddQTV($email) {
		//Check tk co ton tai chua
		//Them kiem tra số nếu người dùng sđt
		if (is_numeric($email)) {
		$check2 = $this->db->query("SELECT * FROM member WHERE phone='$email'");
		} else {
		$check2 = $this->db->query("SELECT * FROM member WHERE email='$email'");
		}
			if ($check2->num_rows > 0) {
				//Lay ID tu Email
					//Bay gio $email chinh la ID o bai viet
					require_once './inl/PROFILE.php';
					$getID = new PROFILE();
					$id_mem = $getID->GetMemberID($email);
					//Email bay gio la ID MEMBER
				$check = $this->db->query("SELECT * FROM admin WHERE email='$id_mem'");
					if ($check->num_rows > 0) 
					{ 
							return false;
					} else {
						//Neu la sdt ti cho vao muc email luon, khoi phai edit CSDL
						$query_it2 = "INSERT INTO admin (email, quyen) VALUES ('$id_mem', '0')"; //email o day chinh la ID
						$this->db->query($query_it2);
						return true;
					}
			} else {
				return false;
			}
	}
	//Xoa va Them Tu Khoa trong bo loc
	function XoaTuKhoa($id){
		$query_it2 = "DELETE FROM blockwords WHERE id='$id'";
		$this->db->query($query_it2);												
	}
	function ThemTuKhoa($noidung) {
		$query_it2 = "INSERT INTO blockwords (word) VALUES ('$noidung')";
		$this->db->query($query_it2);	
	}
	//Quan li phan loai NS
	function XoaNS($id){
		$query_it2 = "DELETE FROM phanloai WHERE id='$id'";
		$this->db->query($query_it2);												
	}
	function AddNS($name){
		$query_it2 = "INSERT INTO phanloai (name, duyet) VALUES ('$name', '0')";
		$this->db->query($query_it2);												
	}
	//Check Admin or Mod
	function CheckAdminMod($email){
		//Lay ID tu Email de check
				//Bay gio $email chinh la ID o bai viet
				require_once './inl/PROFILE.php';
				$getID = new PROFILE();
				$id_mem = $getID->GetMemberID($email);
				//Email bay gio la ID MEMBER
		$check = $this->db->query("SELECT * FROM admin WHERE email='$id_mem'"); //bay gio email chinh la ID
			if ($check->num_rows > 0) { 
				$row = $check->fetch_assoc();
				if ($row['quyen'] == 0) {
					$_SESSION['ADMIN'] = 0; //0 la admin full quyen
				} else {
					$_SESSION['ADMIN'] = 1; //1 la kiem duyet vien.
				}
				//return true;
			} 
	}
	//Get thong tin 
	function GetSEO($dv){
			$check = $this->db->query("SELECT * FROM cauhinh");	
			if ($dv == "webname") {
				if ($check->num_rows > 0) { 
					$row = $check->fetch_assoc();
					return $row['webname'];				
				} else {   
					return "";
				}
			}
			if ($dv == "mota") {
				if ($check->num_rows > 0) { 
					$row = $check->fetch_assoc();
					return $row['mota'];				
				} else {   
					return "";
				}
			}
			if ($dv == "tukhoa") {
				if ($check->num_rows > 0) { 
					$row = $check->fetch_assoc();
					return $row['tukhoa'];				
				} else {   
					return "";
				}
			}
			if ($dv == "linkico") {
				if ($check->num_rows > 0) { 
					$row = $check->fetch_assoc();
					return $row['linkico'];				
				} else {   
					return "";
				}
			}
			if ($dv == "linklogo") {
				if ($check->num_rows > 0) { 
					$row = $check->fetch_assoc();
					return $row['linklogo'];				
				} else {   
					return "";
				}
			}
	}
	//Get ads link and img
	function GetADS($dv){
			$check = $this->db->query("SELECT * FROM cauhinh");	
			//Get ads
			if ($dv == "ads1") {
				if ($check->num_rows > 0) { 
					$row = $check->fetch_assoc();
					return $row['ads_vuong'];				
				} else {   
					return "";
				}
			}
			if ($dv == "ads1_link") {
				if ($check->num_rows > 0) { 
					$row = $check->fetch_assoc();
					return $row['ads_vuong_link'];				
				} else {   
					return "";
				}
			}
			if ($dv == "ads2") {
				if ($check->num_rows > 0) { 
					$row = $check->fetch_assoc();
					return $row['ads_hcn'];				
				} else {   
					return "";
				}
			}
			if ($dv == "ads2_link") {
				if ($check->num_rows > 0) { 
					$row = $check->fetch_assoc();
					return $row['ads_hcn_link'];				
				} else {   
					return "";
				}
			}
			if ($dv == "ads3") {
				if ($check->num_rows > 0) { 
					$row = $check->fetch_assoc();
					return $row['ads_banner'];				
				} else {   
					return "";
				}
			}
			if ($dv == "ads3_link") {
				if ($check->num_rows > 0) { 
					$row = $check->fetch_assoc();
					return $row['ads_banner_link'];				
				} else {   
					return "";
				}
			}
	}
		//Update Ads
		function updateADS($img,$link, $vitri){
			if ($vitri == 1) {
				$query_it1 = "UPDATE cauhinh SET ads_vuong='$img', ads_vuong_link='$link'";
				$this->db->query($query_it1);	
			}
			if ($vitri == 2) {
				$query_it1 = "UPDATE cauhinh SET ads_hcn='$img', ads_hcn_link='$link'";
				$this->db->query($query_it1);	
			}
			if ($vitri == 3) {
				$query_it1 = "UPDATE cauhinh SET ads_banner='$img', ads_banner_link='$link'";
				$this->db->query($query_it1);	
			}						
		}
		//Update SEO
		function updateSEO($webname,$mota, $tukhoa, $linkico, $linklogo){
				$query_it1 = "UPDATE cauhinh SET webname='$webname', mota='$mota', tukhoa='$tukhoa', linkico='$linkico', linklogo='$linklogo'";
				$this->db->query($query_it1);					
		}
			function GetCONTACT($dv){
			$check = $this->db->query("SELECT * FROM cauhinh");	
			if ($dv == "phone") {
				if ($check->num_rows > 0) { 
					$row = $check->fetch_assoc();
					return $row['phone'];				
				} else {   
					return "";
				}
			}
			if ($dv == "email") {
				if ($check->num_rows > 0) { 
					$row = $check->fetch_assoc();
					return $row['email'];				
				} else {   
					return "";
				}
			}
			if ($dv == "diachi") {
				if ($check->num_rows > 0) { 
					$row = $check->fetch_assoc();
					return $row['diachi'];				
				} else {   
					return "";
				}
			}
	}
		//Update Contact
		function updateCONTACT($phone,$email, $diachi){
				$query_it1 = "UPDATE cauhinh SET phone='$phone', email='$email', diachi='$diachi'";
				$this->db->query($query_it1);					
		}
	function GetSlide($id, $dv){ //Slide nay dung voi CSDL caid at truoc
			$check = $this->db->query("SELECT * FROM slide WHERE id='$id'");	
				if ($check->num_rows > 0) { 
					$row = $check->fetch_assoc();	
					if ($dv == "heading") {
						return $row['heading'];
					}
					if ($dv == "something") {
						return $row['something'];
					}
					if ($dv == "image") {
						return $row['image'];
					}
				} else {   
					return "";
				}
			
	}
	//Update Slide
		function updateSlide($id, $heading,$something, $image){
				$query_it1 = "UPDATE slide SET heading='$heading', something='$something', image='$image' WHERE id='$id'";
				$this->db->query($query_it1);					
		}
	//Cac chuc nang slide tren bi vo hieu hoa roi nha, bay gio thi tui lay slide ngau nhien luon
	//Get nguoi kiem duyet
	function getSlideHome(){
		$check = $this->db->query("SELECT * FROM thread ORDER BY RAND () LIMIT 3");
			if ($check->num_rows > 0) { 
			$num = 0;
				while($row2 = $check->fetch_assoc()) {			
					//Đung e lay URL
					require_once 'VIEW.php';
					$getURL = new VIEW();
						if ($row2['duyet'] == 0) {
							//Neu bai viet duyet roi
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
							if ($num == 0) { //Neu num la 0
							echo '<div class="item active">
									<a href="/post/'.$getURL->textToURL($row2["tengiong"])."_".$row2["id"].'.html"><img src="'.$row2['img'].'" alt="'.$row2['tengiong'].'" style="width:100%;"></a>
									<div class="carousel-caption">
									  <h3>'.$row2['tengiong'].'</h3>
									  <p>'.$mota.'</p>
									</div>
								  </div>';
								  $num++;
							} else {
								echo '<div class="item">
									<a href="/post/'.$getURL->textToURL($row2["tengiong"])."_".$row2["id"].'.html"><img src="'.$row2['img'].'" alt="'.$row2['tengiong'].'" style="width:100%;"></a>
									<div class="carousel-caption">
									  <h3>'.$row2['tengiong'].'</h3>
									  <p>'.$mota.'</p>
									</div>
								  </div>';
							}
							
							
					}
				}
			} 
	}
	//Cai App ID vs Key nam ben DB.PHP chi de read, ben file admin duoc updat ne :D
		//Update APPID vs KEY SECRET
		function updateApp($type, $id,$key){
			switch ($type) {
				case "facebook":
					$query_it1 = "UPDATE cauhinh SET fbid='$id', fbkey='$key'";
					$this->db->query($query_it1);	
					break;
				case "google":
					$query_it1 = "UPDATE cauhinh SET ggid='$id', ggkey='$key'";
					$this->db->query($query_it1);	
					break;
				case "zalo":
					$query_it1 = "UPDATE cauhinh SET zlid='$id', zlkey='$key'";
					$this->db->query($query_it1);	
					break;
				default:
				//empty
			}					
		}
			//Duyet vs Xoa trong kiem duyet
			function DuyetPLvsThread($id, $idthread){
				$query_it1 = "UPDATE phanloai SET duyet='0' WHERE id='$id'";
				$this->db->query($query_it1);
				$query_it2 = "UPDATE thread SET duyet='0' WHERE id='$idthread'";
				$this->db->query($query_it2);	
			}
			function DuyetThread($id){
				$query_it2 = "UPDATE thread SET duyet='0' WHERE id='$id'";
				$this->db->query($query_it2);	
			}
			function XoaPLvsThread($id, $idthread){
				$query_it1 = "DELETE FROM phanloai WHERE id='$id'";
				$this->db->query($query_it1);
				$query_it2 = "DELETE FROM thread WHERE id='$idthread'";
				$this->db->query($query_it2);	
			}
			//Xoa Thread
			function XoaThread($id){
				$query_it2 = "DELETE FROM thread WHERE id='$id'";
				$this->db->query($query_it2);	
			}
	//Hien bai kiem duyet
	function getNamePhanloai($id){
		$get_pl = $this->db->query("SELECT * FROM phanloai WHERE id='$id'");
		if ($get_pl->num_rows > 0) {
			$rows_pl = $get_pl->fetch_assoc();
			return $rows_pl['name'];
		} else {
			return "";
		}
	}
	function getDuyetPhanloai($id){
		$get_pl = $this->db->query("SELECT * FROM phanloai WHERE id='$id'");
		if ($get_pl->num_rows > 0) {
			$rows_pl = $get_pl->fetch_assoc();
			$duyet = $rows_pl['duyet'];
			if ($duyet == 0) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	function sendCanhBao($id, $noidung){
		$query_it2 = "UPDATE thread SET duyet='2', ghichu='$noidung' WHERE id='$id'";
		$this->db->query($query_it2);	
	}
	////Cai nay se kiem ky khi POST!!!!!!!!!!!!!!!
	////Cai nay se kiem ky khi POST!!!!!!!!!!!!!!!
	////Cai nay se kiem ky khi POST!!!!!!!!!!!!!!!
	////Cai nay se kiem ky khi POST!!!!!!!!!!!!!!!
	////Cai nay se kiem ky khi POST!!!!!!!!!!!!!!!
	////Cai nay se kiem ky khi POST!!!!!!!!!!!!!!!
	////Cai nay se kiem ky khi POST!!!!!!!!!!!!!!!
	function showDuyet(){
		$check = $this->db->query("SELECT * FROM thread WHERE duyet='1' ORDER BY time DESC LIMIT 1");
			if ($check->num_rows > 0) { // If Returned user .
				//while($row = $check->fetch_assoc()) {
					$row = $check->fetch_assoc();
					//Lay thong tin nguoi dung
					$id_post = $row["email"];
					$gets = $this->db->query("SELECT * FROM member WHERE id='$id_post'"); //Email bay gio la ID
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
						//Hien mo ta day du de kiem duyet
						$mota = $row["mota"];
						//Get phan loai va phan loai moi
						$phanloai = $row["phanloai"];
						$duyetchua = "";
						$text_duyet = "Duyệt bài này";
						$text_xoa = "Xoá bài này";
						if (!$this->getDuyetPhanloai($phanloai)) {
							$duyetchua = '  <span class="input-group-addon">Do người dùng thêm vào</span>';
							$text_duyet = "Duyệt bài này và thêm loại nông sản";
							$text_xoa = "Xoá bài này và loại nông sản";
						}
						$name_PL = $this->getNamePhanloai($phanloai);
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
												<p class="pull-right">Thời gian trồng: <b>'.$trong.'</b><br/>Thời gian thu hoạch: <b>'.$thuhoach.'</b></p>
										<!--EndAdd-more-->
							</div>
							</div>
							</div>
							<!--End mot post--><br/>	<div class="panelCS panel-custom"><div class="text-center">';
													//Kiem tra co anh phu hay ko?
						if (!empty($row["img1"])) {
							echo ' <img id="img_news" src="'.$row["img1"].'"/>';
						}
												//Kiem tra co anh phu hay ko?
						if (!empty($row["img2"])) {
							echo ' <img id="img_news" src="'.$row["img2"].'"/>';
						}
												//Kiem tra co anh phu hay ko?
						if (!empty($row["img3"])) {
							echo ' <img id="img_news" src="'.$row["img3"].'"/>';
						}
												//Kiem tra co anh phu hay ko?
						if (!empty($row["img4"])) {
							echo ' <img id="img_news" src="'.$row["img4"].'"/>';
						}
							echo '</div></div><form method="POST" action="/kiem-duyet-vien.html"><div class="row"><div class="col-md-6"><div class="panel panel-custom">

		  <div class="panel-heading" id="SEO">Thông tin khác</div>

		  <div class="panel-body">
								
								<!--ID-->
								<div class="input-group">
								  <span class="input-group-addon">ID Thread</span>
								  <input type="number" class="form-control" id="id_thread" name="id_thread" readonly="" value="'.$row["id"].'">
								   <span class="input-group-addon">ID Phân loại</span>
								  <input type="number" class="form-control" id="id_PL" name="id_PL" readonly="" value="'.$phanloai.'">
								</div><br/>
								<!--PL-->
								<div class="input-group">
								  <span class="input-group-addon">Loại nông sản</span>
								  <input type="text" class="form-control" id="name_pl" name="name_pl" readonly="" value="'.$name_PL.'">
								'.$duyetchua.'
								</div><br/>
							<!--POST-->	
							<div class="text-right">	
							<input type="submit" class="btn btn-danger btn-sm" name="post_xoa"  value="'.$text_xoa.'"/>
							 <input type="submit" class="btn btn-success btn-sm" name="post_duyet"  value="'.$text_duyet.'"/>
							</div></div></div></div>';
							echo '<div class="col-md-6"><div class="panel panel-custom">

		  <div class="panel-heading">Cảnh báo và duyệt lại</div>

		  <div class="panel-body">							
								<!--GhiChu-->
								 <label>Ghi chú:</label>
								   <div class="form-group">
									<textarea class="form-control" id="ghichu" name="ghichu" rows="3"  placeholder="Ví dụ: Không đáp ứng yêu cầu" ></textarea>
								  </div>
							<!--POST-->	
							<div class="text-right">
							 <input type="submit" class="btn btn-warning btn-sm" name="post_canhbao"  value="Gửi cảnh báo và bỏ qua bài viết"/>
							</div></div></div></div></div></div></div></form>';
						}
				// }
			} else {   //	 if no thread . 
				echo '<div class="alert alert-warning" role="alert">Hiện chưa có bài viết để kiểm duyệt!</div>';
			}
	}
}
?>