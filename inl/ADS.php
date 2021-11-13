<?php
/* Thiết kế và phát triển bởi Nguyễn Trung Nhẫn
*	Contact me: trungnhan0911@yandex.com
*	Github: https://github.com/nhannt201
*	Vui lòng không xoá những chú thích này để tôn trọng quyền tác giả
*/
	require_once './_config.php';	
class ADS {
 
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

}
?>