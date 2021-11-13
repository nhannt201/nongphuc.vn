<?php
/* Thiết kế và phát triển bởi Nguyễn Trung Nhẫn
*	Contact me: trungnhan0911@yandex.com
*	Github: https://github.com/nhannt201
*	Vui lòng không xoá những chú thích này để tôn trọng quyền tác giả
*/
	require_once './inl/DB.php';
	$newDB = new DB();
	if (isset($_SESSION['GUEST'])) {
	if (isset($_GET['province'])) {
		$vauluee=trim(addslashes($_GET['province']));
		$newDB->showDistrict($vauluee);
	} else if (isset($_GET['district'])) {
		if (isset($_GET['wald'])) {
			$huyen=trim(addslashes($_GET['district']));
			$xaa=trim(addslashes($_GET['wald']));
			$newDB->showWard($huyen, $xaa);
		}
	}

}