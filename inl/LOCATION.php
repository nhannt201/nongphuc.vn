<?php
/* Thiết kế và phát triển bởi Nguyễn Trung Nhẫn
*	Contact me: trungnhan0911@yandex.com
*	Github: https://github.com/nhannt201
*	Vui lòng không xoá những chú thích này để tôn trọng quyền tác giả
*/
	require_once './_config.php';	
class LOCATION {
	 
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

	//Khu xu li bai post moi
	function getAddress($a, $b, $c) {
		$tinh = "";
		$huyen ="";
		$xa = "";
		$get_tinh = $this->db->query("SELECT * FROM province WHERE provinceid='$c'");
		$get_huyen = $this->db->query("SELECT * FROM district WHERE districtid='$b'");
		$get_xa = $this->db->query("SELECT * FROM ward WHERE wardid='$a'");
		if ($get_tinh->num_rows > 0) {
				$laytinh = $get_tinh->fetch_assoc();	
				$tinh = $laytinh['name'];
		}
		if ($get_huyen->num_rows > 0) {
				$layhuyen = $get_huyen->fetch_assoc();	
				$huyen = $layhuyen['name'];
		}
		if ($get_xa->num_rows > 0) {
				$layxa = $get_xa->fetch_assoc();	
				$xa = $layxa['name'];
		}
		return $xa.", ".$huyen.", ".$tinh;
	}
	//Check de tranh bi hack SQL J...
	//Lay Xa
	function getXa($a) {
		$xa = "";
		$get_xa = $this->db->query("SELECT * FROM ward WHERE wardid='$a'");
		if ($get_xa->num_rows > 0) {
				$layxa = $get_xa->fetch_assoc();	
				$xa = $layxa['name'];
		}
		return $xa;
	}
	//Check Xa
	function checkXa($a) {
		$get_xa = $this->db->query("SELECT * FROM ward WHERE wardid='$a'");
		if ($get_xa->num_rows > 0) {
			return true;
		} else {
		return false;
		}
	}
	//Lay Huyen
		function getHuyen( $b) {
		$huyen ="";
		$get_huyen = $this->db->query("SELECT * FROM district WHERE districtid='$b'");
		if ($get_huyen->num_rows > 0) {
				$layhuyen = $get_huyen->fetch_assoc();	
				$huyen = $layhuyen['name'];
		}
		return $huyen;
	}
	//Check Huyen
	function checkHuyen( $b) {
		$get_huyen = $this->db->query("SELECT * FROM district WHERE districtid='$b'");
		if ($get_huyen->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
	//Lay tinh
		function getTinh($c) {
		$tinh = "";
		$get_tinh = $this->db->query("SELECT * FROM province WHERE provinceid='$c'");
		if ($get_tinh->num_rows > 0) {
				$laytinh = $get_tinh->fetch_assoc();	
				$tinh = $laytinh['name'];
		}
		return $tinh;
	}
	//Check Tinh
	function checkTinh($c) {
		$get_tinh = $this->db->query("SELECT * FROM province WHERE provinceid='$c'");
		if ($get_tinh->num_rows > 0) {
			return true;
		} else {
		return false;
		}
	}
	
}
?>