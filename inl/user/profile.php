<?php
/* Thiết kế và phát triển bởi Nguyễn Trung Nhẫn
*	Contact me: trungnhan0911@yandex.com
*	Github: https://github.com/nhannt201
*	Vui lòng không xoá những chú thích này để tôn trọng quyền tác giả
*/
require_once './inl/PROFILE.php';
$output = "";
$profile = new PROFILE();
if (isset($_SESSION['EMAIL'])) { //Kiem tra email ton tai chua
	$email = $_SESSION['EMAIL'];
	if (!$profile->CheckName($email)) { //Phong khi tai khoan bi xoa ma van con duy tri dang nhap
		session_unset();
		echo '<script>window.location.replace("'.$domain_home.'");</script>';
		exit;
	}
} else {
	//Truong hop dung SDT
	if (isset($_SESSION['PHONE'])) { //Kiem tra email ton tai chua
		$email = $_SESSION['PHONE'];
		if (!$profile->CheckName($email)) { //Phong khi tai khoan bi xoa ma van con duy tri dang nhap
			session_unset();
			echo '<script>window.location.replace("'.$domain_home.'");</script>';
			exit;
		}
	} else {
		echo '<script>window.location.replace("'.$domain_home.'");</script>';
		exit;
	}
}

if (isset($_POST['savedata'])) {
	$fullname = trim(htmlspecialchars($_POST['my_fullname']));
	$my_email = trim(($_POST['my_email']));
	if (is_numeric($email)) {
		//Chi kiem tra email khi dang nhap bang sdt
		if (!filter_var($my_email, FILTER_VALIDATE_EMAIL)) {
			$output = '<div class="alert alert-danger" role="alert">Địa chỉ Email không hợp lệ!</div>';
		}
	}	
	$sex = (int)trim($_POST['my_sex']);
	if (strlen($sex) > 1) {
		$output = '<div class="alert alert-danger" role="alert">Giới tính không hợp lệ!</div>';
	}
	$birthday = ($_POST['my_birthday']);
	//$cat_ngay = explode(".", $birthday);
	if (!$profile->validateDate($birthday)) {  $status = 0;  $output = '<div class="alert alert-danger" role="alert">Ngày tháng năm sinh không hợp lệ!</div>'; }
	//if (trim($cat_ngay[2]) == date("Y")) { $status = 0; $output = '<div class="alert alert-danger" role="alert">Ngày tháng năm sinh không hợp lệ!</div>'; }
	$numberphone = ($_POST['my_phone']);
	if (!is_numeric($numberphone)) {$output = '<div class="alert alert-danger" role="alert">Số điện thoại không hợp lệ!</div>';}
	$address = trim(htmlspecialchars($_POST['my_address']));
	$aboutme = trim(htmlspecialchars($_POST['my_about']));
	//Sau khi check, tien hành update
	$profile->UpdateName($email, $fullname);
	$profile->UpdateSex($email, $sex);
	$status = 1;
	//kiem tra la sdt hay email
	if (is_numeric($email)) {
		//neu la sdt thi update email
		if ($profile->CheckEmail($my_email)) {
			$output = '<div class="alert alert-danger" role="alert">Email này đã được sử dụng với tài khoản khác!</div>';
			$status = 0;
		} else {
			$profile->UpdateEmail($email, $my_email);
		}
	} else {
		//neu la email
		if ($profile->CheckEmail($numberphone)) {
			$output = '<div class="alert alert-danger" role="alert">Số điện thoại này đã được sử dụng với tài khoản khác!</div>';
			$status = 0;
		} else {
			$profile->UpdatePhone($email, $numberphone);
		}
	}
	//Kiem tra dia chi hop le
	if (is_numeric($address)) {
		$output = '<div class="alert alert-danger" role="alert">Địa chỉ không hợp lệ. Vui lòng thử lại!</div>';
		$status = 0;
	}
	if (strlen($address) < 10) {
		$output = '<div class="alert alert-danger" role="alert">Địa chỉ không hợp lệ. Vui lòng thử lại!</div>';
		$status = 0;
	}
	if ($status == 1) {
	$profile->UpdateAddress($email, $address);
	$profile->UpdateBirthday($email, $birthday);
	$profile->UpdateAboutMe($email, $aboutme);
	$profile->UpdateTime($email);
	$output = '<div class="alert alert-success" role="alert">Cập nhật thông tin cá nhân thành công!</div>';
	echo '<script>window.location.replace("'.$domain_home.'tai-khoan.html#updatesuccess");</script>';
	}
}
?>
<article class="container">
<div class="row">
<div class="col-md-8">
<!--Nam vao vung can le trai-->
<!--<div class="canbang_form">-->
<div class="page-header">

  <h1>Quản lí tài khoản<!--<small>Xin chào, <?php echo $_SESSION['FULLNAME']; ?>!</small>--></h1>

</div>
<!--Profile-->
<div class="panel panel-custom">

  <div class="panel-heading">Thông tin cá nhân</div>

  <div class="panel-body">

	<div class="panel-body">
	 <form id="frm_profile" method="POST" action="/tai-khoan.html#update">
		 <?php echo $output; ?>
			<!--InforPrivate-->
			<div class="input-group">
			  <span class="input-group-addon">Họ và tên(<b>*</b>)</span>
			  <input type="text" class="form-control" id="my_fullname" name="my_fullname" value="<?php ($profile->GetName($email)); ?>" placeholder="Vd: Trần Văn B, tên sẽ hiển thị công khai" required="required">
			</div> <br/>
		<!--Sex-->	 
			<div class="form-group">
			  <label for="my_sex">Giới tính:</label>
			  <select class="form-control" id="my_sex" name="my_sex">
			  <?php if ($profile->GetSex($email)): ?>
				<option value="0" selected>Nam</option>
				<option value="1">Nữ</option>
				<?php else: ?>
				<option value="0">Nam</option>
				<option value="1" selected>Nữ</option>
				<?php endif ?>
			  </select>
			</div>
		<!--DateDay-->
				 <label for="sel1">Sinh nhật:</label>
				 <!-- Datepicker as text field -->         
				  <div class="input-group date" data-date-format="dd.mm.yyyy">
					<input  type="text" id="my_birthday" name="my_birthday" value="<?php $profile->GetBirthday($email); ?>" class="form-control" placeholder="dd.mm.yyyy">
					<div class="input-group-addon" >
					  <span class="glyphicon glyphicon-th"></span>
					</div>
				  </div>
				<script id="rendered-js">
				$('.input-group.date').datepicker({ format: "dd.mm.yyyy" });
					</script><br/>
			  <?php
			  if (is_numeric($email)): //Neu la so dien thoai thi cho email edit dc va nguoc lai?>
			  			 <!--Mail-->	
			<div class="input-group">
			  <span class="input-group-addon">E-mail (<b>*</b>)</span>
			  <input type="email" class="form-control" id="my_email" name="my_email" value="<?php $profile->GetEmail($email); ?>" placeholder="example_mail@example.com, thông tin quan trọng" required="required"> 
			</div><br/>
				  <!--Phone-->	
			<div class="input-group">
			  <span class="input-group-addon">SĐT(<b>*</b>)</span>
			  <input type="number" class="form-control" id="my_phone" name="my_phone" readonly value="<?php $profile->GetPhone($email); ?>" placeholder="Số điện thoại của bạn (+84), dùng để khách hàng liên hệ" required="required">
			</div><br/>
			 <?php else: ?>
				  			 <!--Mail-->	
			<div class="input-group">
			  <span class="input-group-addon">E-mail (<b>*</b>)</span>
			  <input type="email" class="form-control" id="my_email" name="my_email" readonly value="<?php echo $email; ?>" placeholder="example_mail@example.com, địa chỉ bắt buộc để đăng nhập" required="required">
			</div><br/>
							  <!--Phone-->	
			<div class="input-group">
			  <span class="input-group-addon">SĐT(<b>*</b>)</span>
			  <input type="number" class="form-control" id="my_phone" name="my_phone"  value="<?php $profile->GetPhone($email); ?>" placeholder="Số điện thoại của bạn (84), dùng để khách hàng liên hệ" required="required">
			</div><br/>
			  <?php endif ?>

		
			<!--MyHouse-->	
			<div class="input-group">
			  <span class="input-group-addon">Địa chỉ (<b>*</b>)</span>
			  <input type="text" class="form-control" id="my_address" name="my_address" value="<?php $profile->GetAddress($email); ?>" placeholder="Địa chỉ của bạn" required="required">
			</div><br/>
			  <!--Intro_me-->
			 <label>Giới thiệu về bạn:</label>
			   <div class="form-group">
				<textarea class="form-control" id="my_about" name="my_about" rows="3" placeholder="Một vài điều về bản thân bạn, nghề nghiệp, trồng gì, v.v..."><?php $profile->GetAboutMe($email); ?></textarea>
			  </div><br/>
		<!--Save-->	
			<div class="text-right">
			 <input type="submit" class="btn btn-success btn-sm" name="savedata" value="Lưu thông tin"/>
			</div>
				</div>
		</div>
	</form>

  </div>
</div>
<!--Vung can le phai-->
	<div class="page-header">

	  <h1><small>Quản lí các liên kết MXH</small></h1>

	</div>
	<div class="col-md-4">
		<!--ThongtinSocial-->
		<div class="panel panel-custom">

		  <div class="panel-heading" id="socialnetworking" >Mạng xã hội</div>

		  <div class="panel-body">

		  <form>
			<!--Google-->
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-google"></i></span>	 
					<input type="text" class="form-control" readonly value="<?php ($profile->GetGGID($email)); ?>"	>
					<?php if ($profile->CheckGGID($email)): ?>
					<span class="input-group-addon" onClick="clickRemove(0)"><i class="glyphicon glyphicon-remove"></i></span>
					<?php else: ?>
					<span class="input-group-addon"><a href="/login-google.html">Liên kết</a></span>
					<?php endif ?>
				</div>	
			</div>
			<!--Facebook-->
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-facebook"></i></span>	 
					<input type="text" class="form-control" readonly value="<?php ($profile->GetFBID($email)); ?>">	
					<?php if ($profile->CheckFBID($email)): ?>
					<span class="input-group-addon" onClick="clickRemove(1)"><i class="glyphicon glyphicon-remove"></i></span>
					<?php else: ?>
					<span class="input-group-addon"><a href="/login-facebook.html">Liên kết</a></span>
					<?php endif ?>					
				</div>
			</div>
			<!--Zalo-->
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-zalo"><img src="https://i.imgur.com/T8l6pjE.png" width="15px"/></i></span>	 
					<input type="text" class="form-control" readonly value="<?php ($profile->GetZLID($email)); ?>">
					<?php if ($profile->CheckZLID($email)): ?>
					<span class="input-group-addon" onClick="clickRemove(2)"><i class="glyphicon glyphicon-remove"></i></span>
					<?php else: ?>
					<span class="input-group-addon"><a href="/login-zalo.html">Liên kết</a></span>
					<?php endif ?>
				</div>
			</div>
			<div class="clearfix">
           <div class="text-center"> <label  id="note_ps">Liên kết mạng xã hội giúp bạn dễ dàng đăng nhập mà không cần mật khẩu.</label></div>	   
        </div>  
		</form>

		  </div>

		</div>
		<?php require_once './inl/ADS.php';
		$getADS = new ADS();
		if ($getADS->GetADS("ads1")):
		?>
		<!--Panel Ads-->
		<div class="panel panel-default" id="ads-vuong">
		<a rel="nofollow" href="<?php echo $getADS->GetADS("ads1_link"); ?>" target="_blank"><img src="<?php echo $getADS->GetADS("ads1"); ?>" width="100%"/></a>
		</div>
		<?php endif ?>
		</div>
	</div>
</div>
 <script type="text/javascript">
 function clickRemove(phuongthuc) {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		
	  if (this.readyState == 4 && this.status == 200) {
		window.location.replace("<?php echo $domain_home.'tai-khoan.html' ?>");
	  }
	};
	xhttp.open("GET", "remove-connect.php?method=" + phuongthuc, true);
	xhttp.send();
}
 </script>
</article>