<?php
/* Thiết kế và phát triển bởi Nguyễn Trung Nhẫn
*	Contact me: trungnhan0911@yandex.com
*	Github: https://github.com/nhannt201
*	Vui lòng không xoá những chú thích này để tôn trọng quyền tác giả
*/
	require_once './_config.php';	
class SITEMAP {
	 
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
	function getThread($domain){
		$check = $this->db->query("SELECT * FROM thread WHERE duyet='0' ORDER BY time DESC LIMIT 10000");
			if ($check->num_rows > 0) { // If Returned user .
				while($row = $check->fetch_assoc()) {
						//Xu li thoi gian
						if (empty($row['time_edit'])) {
						$time_mod = date('c', $row['time']);
						} else {
						$time_mod = date('c', $row['time_edit']);
						}
						//Chuyen title sang urrl
						require_once './inl/VIEW.php';
						$view = new VIEW();		
						//In ra voi bai viet
						 echo '   <url>   
						  <loc>'.$domain.'post/'.$view->textToURL($row["tengiong"])."_".$row["id"].'.html</loc>
						  <changefreq>always</changefreq>
						  <lastmod>'.$time_mod.'</lastmod>
						  <priority>0.9</priority>
									</url>'; 
						
				 }
			}
	}
	
}
?>