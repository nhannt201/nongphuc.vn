<?php
/* Thiết kế và phát triển bởi Nguyễn Trung Nhẫn
*	Contact me: trungnhan0911@yandex.com
*	Github: https://github.com/nhannt201
*	Vui lòng không xoá những chú thích này để tôn trọng quyền tác giả
*/
	require_once './_config.php';	
class PROFILE {
	 
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
	//Get ID Social NetWork Connected.
	function GetGGID($email){
		//Them kiem tra số nếu người dùng sđt
		if (is_numeric($email)) {
		$check = $this->db->query("SELECT * FROM member WHERE phone='$email'");
		} else {
		$check = $this->db->query("SELECT * FROM member WHERE email='$email'");
		}
			if ($check->num_rows > 0) { // If Returned user .
				$row = $check->fetch_assoc();
				$google = $row["google"];		
				if (strlen($google) > 1) {echo "Đã liên kết với Google!"; } else { echo "Chưa liên kết với Google"; }								
			}
	}
	function GetMemberID($email){
		//Them kiem tra số nếu người dùng sđt
		if (is_numeric($email)) {
		$check = $this->db->query("SELECT * FROM member WHERE phone='$email'");
		} else {
		$check = $this->db->query("SELECT * FROM member WHERE email='$email'");
		}
			if ($check->num_rows > 0) { // If Returned user .
				$row = $check->fetch_assoc();
				return $row["id"];									
			}
	}
	function GetEmailorPhoneID($id){ //ID la dau vao
		$check = $this->db->query("SELECT * FROM member WHERE id='$id'");
		
			if ($check->num_rows > 0) { // If Returned user .
				$row = $check->fetch_assoc();
				if (empty($row['email'])) {
					return $row["phone"];		
				} else {
					return $row["email"];		
				}
											
			}
	}
	function CheckGGID($email){
		//Them kiem tra số nếu người dùng sđt
		if (is_numeric($email)) {
		$check = $this->db->query("SELECT * FROM member WHERE phone='$email'");
		} else {
		$check = $this->db->query("SELECT * FROM member WHERE email='$email'");
		}
			if ($check->num_rows > 0) { // If Returned user .
				$row = $check->fetch_assoc();
				$google = $row["google"];		
				if (strlen($google) > 1) { return true; } else { return false; }								
			}
	}
	function GetFBID($email){
		//Them kiem tra số nếu người dùng sđt
		if (is_numeric($email)) {
		$check = $this->db->query("SELECT * FROM member WHERE phone='$email'");
		} else {
		$check = $this->db->query("SELECT * FROM member WHERE email='$email'");
		}
			if ($check->num_rows > 0) { // If Returned user .
				$row = $check->fetch_assoc();
				$facebook = $row["facebook"];		
				if (strlen($facebook) > 1) {echo "Đã liên kết với Facebook!";  } else { echo "Chưa liên kết với Facebook"; }				
			}
	}
	function CheckFBID($email){
		//Them kiem tra số nếu người dùng sđt
		if (is_numeric($email)) {
		$check = $this->db->query("SELECT * FROM member WHERE phone='$email'");
		} else {
		$check = $this->db->query("SELECT * FROM member WHERE email='$email'");
		}
			if ($check->num_rows > 0) { // If Returned user .
				$row = $check->fetch_assoc();
				$facebook = $row["facebook"];		
				if (strlen($facebook) > 1) { return true; } else { return false; }								
			}
	}
	function GetZLID($email){
		//Them kiem tra số nếu người dùng sđt
		if (is_numeric($email)) {
		$check = $this->db->query("SELECT * FROM member WHERE phone='$email'");
		} else {
		$check = $this->db->query("SELECT * FROM member WHERE email='$email'");
		}
			if ($check->num_rows > 0) { // If Returned user .
				$row = $check->fetch_assoc();
				$zalo = $row["zalo"];		
				if (strlen($zalo) > 1) { echo "Đã liên kết với Zalo!";  } else { echo "Chưa liên kết với Zalo"; }				
			}
	}
	function CheckZLID($email){
		//Them kiem tra số nếu người dùng sđt
		if (is_numeric($email)) {
		$check = $this->db->query("SELECT * FROM member WHERE phone='$email'");
		} else {
		$check = $this->db->query("SELECT * FROM member WHERE email='$email'");
		}
			if ($check->num_rows > 0) { // If Returned user .
				$row = $check->fetch_assoc();
				$zalo = $row["zalo"];		
				if (strlen($zalo) > 1) { return true; } else { return false; }								
			}
	}
	//Get Profile
	function GetName($email){
		//Them kiem tra số nếu người dùng sđt
		if (is_numeric($email)) {
		$check = $this->db->query("SELECT * FROM member WHERE phone='$email'");
		} else {
		$check = $this->db->query("SELECT * FROM member WHERE email='$email'");
		}
			if ($check->num_rows > 0) { // If Returned user .
				$row = $check->fetch_assoc();
				echo $row["fullname"];					
			}
	}
	
	function CheckName($email){
		//Them kiem tra số nếu người dùng sđt
		if (is_numeric($email)) {
		$check = $this->db->query("SELECT * FROM member WHERE phone='$email'");
		} else {
		$check = $this->db->query("SELECT * FROM member WHERE email='$email'");
		}
			if ($check->num_rows > 0) { // If Returned user .
				return true;		
			} else {
				return false;
			}
	}
	function UpdateName($email, $content){
		//Them kiem tra số nếu người dùng sđt
		if (is_numeric($email)) {
		$check = $this->db->query("SELECT * FROM member WHERE phone='$email'");
		} else {
		$check = $this->db->query("SELECT * FROM member WHERE email='$email'");
		}
			if ($check->num_rows > 0) { // If Returned user .
				$query_it1 = "UPDATE member SET fullname='$content' WHERE email='$email'";
				$this->db->query($query_it1);					
			}
	}
	//Check email ton tai
	function CheckEmail($email){
		//Them kiem tra số nếu người dùng sđt
		if (is_numeric($email)) {
		$check = $this->db->query("SELECT * FROM member WHERE phone='$email'");
		} else {
		$check = $this->db->query("SELECT * FROM member WHERE email='$email'");
		}
			if ($check->num_rows > 0) { // If Returned user .
				$row = $check->fetch_assoc();
				if (is_numeric($email)) {
					if (isset($_SESSION['PHONE'])) {
						//Neu la SDT
						if ($row['phone'] == $_SESSION['PHONE']) {
							return false;
						} else {
							return true;
						}
					} else {
						//Neu la email
						if ($row['email'] == $_SESSION['EMAIL']) {
						return false;
						} else {
							return true;
						}
					}
				} else {
					if (isset($_SESSION['EMAIL'])) {
						//Neu la SDT
						if ($row['email'] == $_SESSION['EMAIL']) {
							return false;
						} else {
							return true;
						}
					} else {
						//Neu la email
						if ($row['phone'] == $_SESSION['PHONE']) {
						return false;
						} else {
							return true;
						}
					}
				}			
			} else {
				return false;
			}
	}
	//Them get Email
	function GetEmail($email){
		//Them kiem tra số nếu người dùng sđt
		if (is_numeric($email)) {
		$check = $this->db->query("SELECT * FROM member WHERE phone='$email'");
		} else {
		$check = $this->db->query("SELECT * FROM member WHERE email='$email'");
		}
			if ($check->num_rows > 0) { // If Returned user .
				$row = $check->fetch_assoc();
				echo $row["email"];					
			}
	}
	function UpdateEmail($email, $content){ //Chac chan phai co sdt moi update dc
		$check = $this->db->query("SELECT * FROM member WHERE phone='$email'");
			if ($check->num_rows > 0) { // If Returned user .
				$query_it1 = "UPDATE member SET email='$content' WHERE phone='$email'";
				$this->db->query($query_it1);					
			}
	}
	function GetPhone($email){
		//Them kiem tra số nếu người dùng sđt
		if (is_numeric($email)) {
		$check = $this->db->query("SELECT * FROM member WHERE phone='$email'");
		} else {
		$check = $this->db->query("SELECT * FROM member WHERE email='$email'");
		}
			if ($check->num_rows > 0) { // If Returned user .
				$row = $check->fetch_assoc();
				echo $row["phone"];					
			}
	}
	function CheckPhone($email){
		//Them kiem tra số nếu người dùng sđt
		if (is_numeric($email)) {
		$check = $this->db->query("SELECT * FROM member WHERE phone='$email'");
		} else {
		$check = $this->db->query("SELECT * FROM member WHERE email='$email'");
		}
			if ($check->num_rows > 0) { // If Returned user .
				$row = $check->fetch_assoc();
				$phone = $row['phone'];
				if (strlen($phone) > 6) {
					return true;
				} else {return false;}
			} else {
				return false;
			}
	}
	//Khuc duoi day can kiem tra ky!!!!!!!!!!!!!!!!
	//Khuc duoi day can kiem tra ky!!!!!!!!!!!!!!!!
	//Khuc duoi day can kiem tra ky!!!!!!!!!!!!!!!!
	//Khuc duoi day can kiem tra ky!!!!!!!!!!!!!!!!
	//Khuc duoi day can kiem tra ky!!!!!!!!!!!!!!!!
	//Khuc duoi day can kiem tra ky!!!!!!!!!!!!!!!!
	//Khuc duoi day can kiem tra ky!!!!!!!!!!!!!!!!
	//Khuc duoi day can kiem tra ky!!!!!!!!!!!!!!!!
	function UpdatePhone($email, $content){ //chac chan la email moi update duoc
		$check = $this->db->query("SELECT * FROM member WHERE email='$email'");
			if ($check->num_rows > 0) { // If Returned user .
				$query_it1 = "UPDATE member SET phone='$content' WHERE email='$email'";
				$this->db->query($query_it1);					
			}
	}
	function GetAddress($email){
		//Them kiem tra số nếu người dùng sđt
		if (is_numeric($email)) {
		$check = $this->db->query("SELECT * FROM member WHERE phone='$email'");
		} else {
		$check = $this->db->query("SELECT * FROM member WHERE email='$email'");
		}
			if ($check->num_rows > 0) { // If Returned user .
				$row = $check->fetch_assoc();
				echo $row["address"];					
			}
	}
	function UpdateAddress($email, $content){
		//Them kiem tra số nếu người dùng sđt
		if (is_numeric($email)) {
		$check = $this->db->query("SELECT * FROM member WHERE phone='$email'");
		} else {
		$check = $this->db->query("SELECT * FROM member WHERE email='$email'");
		}
			if ($check->num_rows > 0) { // If Returned user .
				if (is_numeric($email)) {
					$query_it1 = "UPDATE member SET address='$content' WHERE phone='$email'";
					$this->db->query($query_it1);			
				} else {
					$query_it1 = "UPDATE member SET address='$content' WHERE email='$email'";
					$this->db->query($query_it1);			
				}				
			}
	}
	function GetBirthday($email){
		//Them kiem tra số nếu người dùng sđt
		if (is_numeric($email)) {
		$check = $this->db->query("SELECT * FROM member WHERE phone='$email'");
		} else {
		$check = $this->db->query("SELECT * FROM member WHERE email='$email'");
		}
			if ($check->num_rows > 0) { // If Returned user .
				$row = $check->fetch_assoc();
				echo $row["birthday"];					
			}
	}
	function UpdateBirthday($email, $content){
		//Them kiem tra số nếu người dùng sđt
		if (is_numeric($email)) {
		$check = $this->db->query("SELECT * FROM member WHERE phone='$email'");
		} else {
		$check = $this->db->query("SELECT * FROM member WHERE email='$email'");
		}
			if ($check->num_rows > 0) { // If Returned user .
				if (is_numeric($email)) {
					$query_it1 = "UPDATE member SET birthday='$content' WHERE phone='$email'";
					$this->db->query($query_it1);			
				} else {
					$query_it1 = "UPDATE member SET birthday='$content' WHERE email='$email'";
					$this->db->query($query_it1);			
				}				
			}
	}
	function GetSex($email){
		//Them kiem tra số nếu người dùng sđt
		if (is_numeric($email)) {
		$check = $this->db->query("SELECT * FROM member WHERE phone='$email'");
		} else {
		$check = $this->db->query("SELECT * FROM member WHERE email='$email'");
		}
			if ($check->num_rows > 0) { // If Returned user .
				$row = $check->fetch_assoc();
				$sex = $row["sex"];
				if ($sex == 0) {
					return true; 
				}	else { return false; }			
			}
	}
	function UpdateSex($email, $content){
		//Them kiem tra số nếu người dùng sđt
		if (is_numeric($email)) {
		$check = $this->db->query("SELECT * FROM member WHERE phone='$email'");
		} else {
		$check = $this->db->query("SELECT * FROM member WHERE email='$email'");
		}
			if ($check->num_rows > 0) { // If Returned user .
				if (is_numeric($email)) {
					$query_it1 = "UPDATE member SET sex='$content' WHERE phone='$email'";
					$this->db->query($query_it1);	
				} else {
					$query_it1 = "UPDATE member SET sex='$content' WHERE email='$email'";
					$this->db->query($query_it1);	
				}				
			}
	}
	function GetAboutMe($email){
		//Them kiem tra số nếu người dùng sđt
		if (is_numeric($email)) {
		$check = $this->db->query("SELECT * FROM member WHERE phone='$email'");
		} else {
		$check = $this->db->query("SELECT * FROM member WHERE email='$email'");
		}
			if ($check->num_rows > 0) { // If Returned user .
				$row = $check->fetch_assoc();
				echo $row["aboutme"];					
			}
	}
	function UpdateAboutMe($email, $content){
		//Them kiem tra số nếu người dùng sđt
		if (is_numeric($email)) {
		$check = $this->db->query("SELECT * FROM member WHERE phone='$email'");
		} else {
		$check = $this->db->query("SELECT * FROM member WHERE email='$email'");
		}
			if ($check->num_rows > 0) { // If Returned user .
				if (is_numeric($email)) {
					$query_it1 = "UPDATE member SET aboutme='$content' WHERE phone='$email'";
					$this->db->query($query_it1);			
				} else {
					$query_it1 = "UPDATE member SET aboutme='$content' WHERE email='$email'";
					$this->db->query($query_it1);		
				}				
			}
	}
	function UpdateTime($email){
		$time=time();
		//Them kiem tra số nếu người dùng sđt
		if (is_numeric($email)) {
		$check = $this->db->query("SELECT * FROM member WHERE phone='$email'");
		} else {
		$check = $this->db->query("SELECT * FROM member WHERE email='$email'");
		}
			if ($check->num_rows > 0) { // If Returned user .
				if (is_numeric($email)) {
					$query_it1 = "UPDATE member SET time_update='$time' WHERE phone='$email'";
					$this->db->query($query_it1);
				} else {
					$query_it1 = "UPDATE member SET time_update='$time' WHERE email='$email'";
					$this->db->query($query_it1);
				}				
			}
	}
	//Remove Connected Social Network
	function deleteConnected($email, $method){
		//Them kiem tra số nếu người dùng sđt
		if (is_numeric($email)) {
		$check = $this->db->query("SELECT * FROM member WHERE phone='$email'");
		} else {
		$check = $this->db->query("SELECT * FROM member WHERE email='$email'");
		}
			if ($check->num_rows > 0) { // If Returned user .
				if ($method == "0") {
						if (is_numeric($email)) {
							$query_it1 = "UPDATE member SET google='' WHERE phone='$email'";
							$this->db->query($query_it1);
						} else {
							$query_it1 = "UPDATE member SET google='' WHERE email='$email'";
							$this->db->query($query_it1);
						}
				}	
				if ($method == "1") {
					if (is_numeric($email)) {
							$query_it1 = "UPDATE member SET facebook='' WHERE phone='$email'";
							$this->db->query($query_it1);
						} else {
							$query_it1 = "UPDATE member SET facebook='' WHERE email='$email'";
							$this->db->query($query_it1);
						}
				}
				if ($method == "2") {
					if (is_numeric($email)) {
							$query_it1 = "UPDATE member SET zalo='' WHERE phone='$email'";
							$this->db->query($query_it1);
						} else {
							$query_it1 = "UPDATE member SET zalo='' WHERE email='$email'";
							$this->db->query($query_it1);
						}
				}
			}
	}
	//Other functions
	//Check Date
	function validateDate($date, $format = 'd.m.Y')
	{
		$d = DateTime::createFromFormat($format, $date);
		// The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
		return $d && $d->format($format) === $date;
	}
	
}
?>