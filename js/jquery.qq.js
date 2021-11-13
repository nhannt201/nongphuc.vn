/* Thiết kế và phát triển bởi Nguyễn Trung Nhẫn
*	Contact me: trungnhan0911@yandex.com
*	Github: https://github.com/nhannt201
*	Vui lòng không xoá những chú thích này để tôn trọng quyền tác giả
*/
function clickProvince() {
  var x = document.getElementById("tinh_tp").selectedIndex;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		
	  if (this.readyState == 4 && this.status == 200) {
		document.getElementById("quan_huyen").innerHTML = '<option value="0">--Quận/Huyện--</option>' + this.responseText;
		document.getElementById("phuong_xa").innerHTML = '<option value="0">--Xã/Phường/Thị Trấn--</option>';
	  }
	};
	  var malog = document.getElementsByTagName("option")[x].value;
	xhttp.open("GET", "vietnam_loc.php?province=" + malog, true);
	xhttp.send();
}
function clickDistrict() {
  var x = document.getElementById("quan_huyen").selectedIndex -1;
  var xx = document.getElementById("tinh_tp").selectedIndex;
  var y = document.getElementById("quan_huyen").options;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		
	  if (this.readyState == 4 && this.status == 200) {
		document.getElementById("phuong_xa").innerHTML = '<option value="0">--Xã/Phường/Thị Trấn--</option>' + this.responseText;
		//alert(this.responseText);
	  }
	};
	var malog = document.getElementsByTagName("option")[x].value;
	var malogxx = document.getElementsByTagName("option")[xx].value;
	//document.getElementById("texttttt").innerHTML = "vietnam_loc.php?district=" + malogxx + "&wald=" + y[x].index;
	xhttp.open("GET", "vietnam_loc.php?district=" + malogxx + "&wald=" + y[x].index, true);
	xhttp.send();
}
