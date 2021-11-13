<?php
/* Thiết kế và phát triển bởi Nguyễn Trung Nhẫn
*	Contact me: trungnhan0911@yandex.com
*	Github: https://github.com/nhannt201
*	Vui lòng không xoá những chú thích này để tôn trọng quyền tác giả
*/
	require_once './_config.php';	
class DB {
 
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
	//Lay Key and Bi mat cho App
	function GetAppID($dv){
			$check = $this->db->query("SELECT * FROM cauhinh");	
			if ($dv == "facebook") {
				if ($check->num_rows > 0) { 
					$row = $check->fetch_assoc();
					return $row['fbid'];				
				} else {   
					return "";
				}
			}
			if ($dv == "google") {
				if ($check->num_rows > 0) { 
					$row = $check->fetch_assoc();
					return $row['ggid'];				
				} else {   
					return "";
				}
			}
			if ($dv == "zalo") {
				if ($check->num_rows > 0) { 
					$row = $check->fetch_assoc();
					return $row['zlid'];				
				} else {   
					return "";
				}
			}
	}
	function GetAppSecret($dv){
		$check = $this->db->query("SELECT * FROM cauhinh");	
			if ($dv == "facebook") {
				if ($check->num_rows > 0) { 
					$row = $check->fetch_assoc();
					return $row['fbkey'];				
				} else {   
					return "";
				}
			}
			if ($dv == "google") {
				if ($check->num_rows > 0) { 
					$row = $check->fetch_assoc();
					return $row['ggkey'];				
				} else {   
					return "";
				}
			}
			if ($dv == "zalo") {
				if ($check->num_rows > 0) { 
					$row = $check->fetch_assoc();
					return $row['zlkey'];				
				} else {   
					return "";
				}
			}
	}
	//Kiem tra Email ai dang ky chua?
	function mailCheck($email){
		//Them kiem tra nếu người dùng dùng sđt
		if (is_numeric($email)) {
		$check = $this->db->query("SELECT * FROM member WHERE phone='$email'");
		} else {
		$check = $this->db->query("SELECT * FROM member WHERE email='$email'");
		}
			if ($check->num_rows > 0) { 
				return true;				
			} else {   
				return false;
			}
	}
	//Login
	function LoginCheck($email, $pass){
		//Them kiem tra số nếu người dùng đk bằng sđt
		if (is_numeric($email)) {
		$check = $this->db->query("SELECT * FROM member WHERE phone='$email'");
		} else {
		$check = $this->db->query("SELECT * FROM member WHERE email='$email'");
		}
			if ($check->num_rows > 0) { // If Returned user .
				$row = $check->fetch_assoc();
				$ps = $row["password"];
				if ($pass == $ps) {
					return true;
				} else {
					return false;
				}						
			} else {   //	 if new user .
				return false;
			}
	}
	//Getdata Login sau khi login xong
	function GetSession($email){
		//Them kiem tra số nếu người dùng đk bằng sđt
		if (is_numeric($email)) {
		$check = $this->db->query("SELECT * FROM member WHERE phone='$email'");
		} else {
		$check = $this->db->query("SELECT * FROM member WHERE email='$email'");
		}
			if ($check->num_rows > 0) { // If Returned user .
				$row = $check->fetch_assoc();
				$_SESSION['FULLNAME'] = $row['fullname'];
				//Kiem tra email ha sdt ton tai de ghi nho
					if (is_numeric($email)) { 
						$_SESSION['PHONE'] = $row['phone'];	
					} else {
						$_SESSION['EMAIL'] = $row['email'];	
					}
			} 
	}
	//Set Admin neu tai khoan dau tien
	function setAdmin($email){
		$check = $this->db->query("SELECT * FROM member");
			if ($check->num_rows > 1) {

			} else {
				//Lay ID thanh vien
				if (is_numeric($email)) {
				$check2 = $this->db->query("SELECT * FROM member WHERE phone='$email'");
				} else {
				$check2 = $this->db->query("SELECT * FROM member WHERE email='$email'");
				}
				$row2 = $check2->fetch_assoc();
				$idd = $row2['id'];
				//Dat admin khi la tai khoan dau tien
				$query_it2 = "INSERT INTO admin (email,quyen) VALUES ('$idd','0')";
				$this->db->query($query_it2);	
			}
	}
	//Su dung cac phuong thuc dang nhap khac de dang ky
	function fbCheck($fuid,$ffname){
		$check = $this->db->query("SELECT * FROM member WHERE facebook='$fuid'");
			if ($check->num_rows > 0) { // If Returned user .
				$row = $check->fetch_assoc();
				$_SESSION['FULLNAME'] = $row['fullname'];
				$_SESSION['EMAIL'] = $row['email'];	
				if (empty($row['email'])) {
					//Neu email trong thi dung sdt
					$_SESSION['PHONE'] = $row['phone'];	
				} else {
					//Neu co email thi dung email
					$_SESSION['EMAIL'] = $row['email'];	
				}
				$_SESSION['LOG'] = 1;
				return true;				
			} else {   //	 if new user . Insert a new record	
				return false;
			}
	}
	function updateFB($fuid,$ffname, $femail){
		//Them kiem tra số nếu người dùng sđt
		if (is_numeric($femail)) {
		$check = $this->db->query("SELECT * FROM member WHERE phone='$femail'");
		} else {
		$check = $this->db->query("SELECT * FROM member WHERE email='$femail'");
		}
			if ($check->num_rows > 0) { 
				if (is_numeric($femail)) {
					//Neu email la sdt, la nguoi dung dang y bang sdt
					$query_it1 = "UPDATE member SET facebook='$fuid' WHERE phone='$femail'";
					$this->db->query($query_it1);
				} else {
					$query_it1 = "UPDATE member SET facebook='$fuid' WHERE email='$femail'";
					$this->db->query($query_it1);
				}
								
			}
	}
	function fbAdd($fuid,$ffname, $femail, $pass){
		$time=time();
		$check = $this->db->query("SELECT * FROM member WHERE facebook='$fuid'");
			if ($check->num_rows > 0) { // If Returned user . update the user record	
				//$query_it1 = "UPDATE member SET fullname='$ffname', email='$femail' WHERE facebook='$fuid'";
				//$this->db->query($query_it1);	
				return false;				
			} else {   //	 if new user
				if (is_numeric($femail)) { //neu dung sdt		
					$query_it2 = "INSERT INTO member (facebook,fullname, phone, password, time) VALUES ('$fuid','$ffname', '$femail', '$pass', '$time')";
					$this->db->query($query_it2);
					$this->setAdmin($femail);					
				} else {
					$query_it2 = "INSERT INTO member (facebook,fullname, email, password, time) VALUES ('$fuid','$ffname', '$femail', '$pass', '$time')";
					$this->db->query($query_it2);
					$this->setAdmin($femail);					
				}			
				return true;
			}
	}
	//Zalo dang xay dung...doi up len host moi code dc
	function zaloCheck($fuid,$ffname){
		$check = $this->db->query("SELECT * FROM member WHERE zalo='$fuid'");
			if ($check->num_rows > 0) { // If Returned user 
				$row = $check->fetch_assoc();
				$_SESSION['FULLNAME'] = $row['fullname'];
				if (empty($row['email'])) {
					//Neu email trong thi dung sdt
					$_SESSION['PHONE'] = $row['phone'];	
				} else {
					//Neu co email thi dung email
					$_SESSION['EMAIL'] = $row['email'];	
				}
				$_SESSION['LOG'] = 1;
				return true;	
			} else {   //	 if new user .
				return false;
			}
	}
	function zaloAdd($fuid,$ffname, $femail, $pass){
		$time=time();
		$check = $this->db->query("SELECT * FROM member WHERE zalo='$fuid'");
			if ($check->num_rows > 0) { // If Returned user 
				return false;	
			} else {   //	 if new user .
				if (is_numeric($femail)) { //neu dung sdt
					$query_it2 = "INSERT INTO member (zalo,fullname, phone, password, time) VALUES ('$fuid','$ffname', '$femail', '$pass', '$time')";
					$this->db->query($query_it2);
					$this->setAdmin($femail);
				} else {				
					$query_it2 = "INSERT INTO member (zalo,fullname, email, password, time) VALUES ('$fuid','$ffname', '$femail', '$pass', '$time')";
					$this->db->query($query_it2);
					$this->setAdmin($femail);					
				}	
				return true;
			}
	}
	function updateZL($fuid,$ffname, $femail){
		//Them kiem tra số nếu người dùng sđt
		if (is_numeric($femail)) {
		$check = $this->db->query("SELECT * FROM member WHERE phone='$femail'");
		} else {
		$check = $this->db->query("SELECT * FROM member WHERE email='$femail'");
		}
			if ($check->num_rows > 0) { // If Returned user .
				if (is_numeric($femail)) {
					$query_it1 = "UPDATE member SET zalo='$fuid' WHERE phone='$femail'";
					$this->db->query($query_it1);	
				} else {
					$query_it1 = "UPDATE member SET zalo='$fuid' WHERE email='$femail'";
					$this->db->query($query_it1);	
				}
								
			}
	}
	//Khu xu li GG
	
	function googleCheck($fuid,$ffname, $femail){ //check qua email, vi gg cung cap email
		$check = $this->db->query("SELECT * FROM member WHERE google='$fuid'");
			if ($check->num_rows > 0) { // If Returned user . update the user record	
				$row = $check->fetch_assoc();
				$_SESSION['FULLNAME'] = $row['fullname'];	
				if (empty($row['email'])) {
					//Neu email trong thi dung sdt
					$_SESSION['PHONE'] = $row['phone'];	
				} else {
					//Neu co email thi dung email
					$_SESSION['EMAIL'] = $row['email'];	
				}	
				$_SESSION['LOG'] = 1;
				//Update id google neu truoc do login qua facebook va zalo chi co ID
				if (is_numeric($femail)) { //neu la so dien thoai
					$query_it1 = "UPDATE member SET google='$fuid' WHERE phone='$femail'";
					$this->db->query($query_it1);	
				} else {
					$query_it1 = "UPDATE member SET google='$fuid' WHERE email='$femail'";
					$this->db->query($query_it1);
				}
				return true;		
			} else {   //	 if new user . Insert a new record	
				return false;
			}
	}
	function updateGG($fuid,$ffname, $femail){
		//Them kiem tra số nếu người dùng sđt
		if (is_numeric($femail)) {
		$check = $this->db->query("SELECT * FROM member WHERE phone='$femail'");
		} else {
		$check = $this->db->query("SELECT * FROM member WHERE email='$femail'");
		}
			if ($check->num_rows > 0) { // If Returned user .
				if (is_numeric($femail)) { 
					$query_it1 = "UPDATE member SET google='$fuid' WHERE phone='$femail'";
					$this->db->query($query_it1);	
				} else {
					$query_it1 = "UPDATE member SET google='$fuid' WHERE email='$femail'";
					$this->db->query($query_it1);		
				}				
			}
	}
	function ggAdd($fuid,$ffname, $femail, $pass){
		$time=time();
		$check = $this->db->query("SELECT * FROM member WHERE google='$fuid'");
			if ($check->num_rows > 0) { // If Returned user . update the user record	
			//	$query_it1 = "UPDATE member SET fullname='$ffname', email='$femail' WHERE google='$fuid'";
			//	$this->db->query($query_it1);	
				return false;			
			} else {   //	 if new user . Insert a new record	
				if (is_numeric($femail)) { 
					$query_it2 = "INSERT INTO member (google, fullname, phone, password, time) VALUES ('$fuid','$ffname', '$femail', '$pass', '$time')";
					$this->db->query($query_it2);
					$this->setAdmin($femail);					
				} else {
					$query_it2 = "INSERT INTO member (google, fullname, email, password, time) VALUES ('$fuid','$ffname', '$femail', '$pass', '$time')";
					$this->db->query($query_it2);
					$this->setAdmin($femail);
				}
				return true;
			}
	}
	//Neu dang ky tai khoan binh thuong
	function normalAdd($ffname, $femail, $pass){
		$time=time();
		//Them kiem tra số nếu người dùng sđt
		if (is_numeric($femail)) {
		$check = $this->db->query("SELECT * FROM member WHERE phone='$femail'");
		} else {
		$check = $this->db->query("SELECT * FROM member WHERE email='$femail'");
		}
			if ($check->num_rows > 0) { // If Returned user . 
				return false;			
			} else {   //	 if new user . Insert a new record	
				if (is_numeric($femail)) {
					$query_it2 = "INSERT INTO member (fullname, phone, password, time) VALUES ('$ffname', '$femail', '$pass', '$time')";
					$this->db->query($query_it2);
					$this->setAdmin($femail);
				} else {
					$query_it2 = "INSERT INTO member (fullname, email, password, time) VALUES ('$ffname', '$femail', '$pass', '$time')";
					$this->db->query($query_it2);
					$this->setAdmin($femail);
				}
				return true;
			}
	}
	
	
	
	
	
	
	
	
	//Search tinh thanh pho xa huyen quan
	function showProvince(){
		$check = $this->db->query("SELECT * FROM province");
			if ($check->num_rows > 0) { // If Returned user .
				while($row = $check->fetch_assoc()) {
					echo '<option value="'.$row['provinceid'].'">'.$row['name'];
				 }
			}
	}
	//Show huyen
	function showDistrict($matinh2){
		$check = $this->db->query("SELECT * FROM district WHERE provinceid='$matinh2'");
			if ($check->num_rows > 0) { // If Returned user .
				while($row = $check->fetch_assoc()) {
					echo '<option value="'.$row['districtid'].'" >'.$row['name']."</option>";
				 }
			}
	}
	//Show xa
	function showWard($matinh, $idwhere){
		//Lay id va tri tri
		$check = $this->db->query("SELECT * FROM district WHERE provinceid='$matinh'");
			$aaa =array();
			if ($check->num_rows > 0) { //
				while($row = $check->fetch_assoc()) {
				array_push($aaa,$row['districtid']);
					//echo '<option value="'.$row['wardid'].'">'.$row['name']."</option>";
					//$check = $this->db->query("SELECT * FROM district WHERE provinceid='$matinh'");
				 }
				 //lay id cua district sao do tra cuu trong xa
				$id_district =  $aaa[$idwhere]; //873HH dong thap
				//print_r($aaa);
				//echo $id_district;
				//echo $matinh;
					$check = $this->db->query("SELECT * FROM ward WHERE districtid='$id_district'");
					if ($check->num_rows > 0) { // If Returned user .
						while($row = $check->fetch_assoc()) {
							echo '<option value="'.$row['wardid'].'" >'.$row['name']."</option>";
						 }
					}
			}
	}
	//Show nong san
	function showNongSan(){
		$check = $this->db->query("SELECT * FROM phanloai WHERE duyet='0'");
			if ($check->num_rows > 0) { // If Returned user .
				while($row = $check->fetch_assoc()) {
					echo '<option value="'.$row['id'].'">'.$row['name'];
				 }
			}
	}
		function showNameNongSan($id){
		$check = $this->db->query("SELECT * FROM phanloai WHERE id='$id'");
			if ($check->num_rows > 0) { // If Returned user .
				$row = $check->fetch_assoc();
				return $row['name'];
				 
			}
	}
	//Tu khoa xau
	function showTuXau(){
		$check = $this->db->query("SELECT * FROM blockwords");
			if ($check->num_rows > 0) { // If Returned user .
				while($row = $check->fetch_assoc()) {
					echo '<option value="'.$row['id'].'">'.$row['word'];
				 }
			}
	}
}
?>