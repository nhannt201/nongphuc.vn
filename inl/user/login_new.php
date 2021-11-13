<?php
/* Thiết kế và phát triển bởi Nguyễn Trung Nhẫn
*	Contact me: trungnhan0911@yandex.com
*	Github: https://github.com/nhannt201
*	Vui lòng không xoá những chú thích này để tôn trọng quyền tác giả
*/
require_once './inl/DB.php';
$output = "";
if (isset($_SESSION['LOG'])) {
	echo '<script>window.location.replace("'.$domain_home.'");</script>';
	exit;
}
if (isset($_POST['submit'])) {
	$email = trim(htmlspecialchars($_POST['email']));
	$fullname = trim(htmlspecialchars($_POST['fullname']));
	$ps1 = $_POST['password'];
	$ps2 = $_POST['repassword'];
	if (!preg_match("/^[a-zA-Z ]*$/",$fullname)) {
		$output = '<span class="text-warning">Tên không hợp lệ. <br/>Vui lòng thử lại...</span>';
	}
	if (strlen($fullname) < 3) {
		$output = '<span class="text-warning">Tên quá ngắn. <br/>Vui lòng thử lại...</span>';
	}
	//Them kiem tra email va sđt
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		if (!is_numeric($email)) {
			$output = '<span class="text-warning">Email hoặc số điện thoại không hợp lệ. <br/>Vui lòng thử lại...</span>';
		}
	}
	if ($ps1 != $ps2) {
		$output = '<span class="text-warning">Mật khẩu không khớp. <br/>Vui lòng thử lại...</span>';
	}
	if (trim(htmlspecialchars($ps1)) == $email) {
		$output = '<span class="text-warning">Mật khẩu không an toàn. <br/>Vui lòng thử lại...</span>';
	}
	if (trim(htmlspecialchars($ps1)) == $fullname) {
		$output = '<span class="text-warning">Mật khẩu không an toàn. <br/>Vui lòng thử lại...</span>';
	}
	//Theo yêu cầu là nông dân dùng nên sẽ giảm bớt yếu tố bảo mật xíu cho phù hợp :(
	//if (strlen($ps1) < 12) {
	//	$output = '<span class="text-warning">Mật khẩu quá ngắn. Tối thiểu 12 kí tự. <br/>Vui lòng thử lại...</span>';
	//}
	//if (is_numeric($ps1)) {
	//	$output = '<span class="text-warning">Mật khẩu không an toàn. <br/>Vui lòng thử lại...</span>';
	//}
	
	$newmem = new DB();
	//Kiem tra email
	if ($newmem->mailCheck($email)) {
		$output = '<span class="text-warning">Email đã tồn tại với tài khoản khác. <br/>Vui lòng thử lại...</span>';
	}
	//Neu dung FB,GG,ZL de dang ky
	if ((isset($_SESSION['FBID']))) {
		if (strlen($_SESSION['FBID']) > 5) {
			if ($newmem->fbAdd($_SESSION['FBID'],$fullname, $email, md5($ps1))) {
				//header("Location: ".$domain_home."/tai-khoan.html");
				echo '<script>window.location.replace("'.$domain_home.'tai-khoan.html");</script>';
			} else {
				$output = '<span class="text-warning">Tài khoản Facebook này đã liên kết với tài khoản khác. <br/>Vui lòng thử lại...</span>';
			}
		}
	} else if ((isset($_SESSION['GGID']))) {
		if (strlen($_SESSION['GGID']) > 5) {
			if ($newmem->ggAdd($_SESSION['GGID'],$fullname, $email, md5($ps1))) {
				echo '<script>window.location.replace("'.$domain_home.'tai-khoan.html");</script>';
			} else {
				$output = '<span class="text-warning">Tài khoản Google này đã liên kết với tài khoản khác. <br/>Vui lòng thử lại...</span>';
			}
		}
	} else if ((isset($_SESSION['ZLID']))) {
		if (strlen($_SESSION['ZLID']) > 5) {
			if ($newmem->zaloAdd($_SESSION['ZLID'],$fullname, $email, md5($ps1))) {
				echo '<script>window.location.replace("'.$domain_home.'tai-khoan.html");</script>';
			} else {
				$output = '<span class="text-warning">Tài khoản Zalo này đã liên kết với tài khoản khác. <br/>Vui lòng thử lại...</span>';
			}
		}
	} else {
	//Dang ky binh thuong
	if ($newmem->normalAdd($fullname, $email, md5($ps1))) {
				echo '<script>window.location.replace("'.$domain_home.'tai-khoan.html");</script>';
			} else {
				$output = '<span class="text-warning">Tài khoản Email này đã liên kết với tài khoản khác. <br/>Vui lòng thử lại...</span>';
			}
	}
	
}
?>
<div class="login-form">
    <form action="/tai-khoan-moi.html" method="post" onSubmit = "return checkPassword(this)" autocomplete="off">
        <h2 class="text-center">Tài khoản mới</h2>
		<?php if ((isset($_SESSION['FBID']))): ?> 
		<div class="alert alert-info text-center" role="alert">Bạn chỉ cần đăng ký một lần!<br/>Lần sau chỉ cần đăng nhập với Facebook mà không cần mật khẩu!</div>	 
		 <div class="form-group">
        	<div class="input-group">
                <span class="input-group-addon"><i class="fa fa-facebook"></i></span>	 
                <input type="number" class="form-control" readonly value="<?php echo $_SESSION['FBID']; ?>">			
            </div>
        </div>
		<?php endif ?>
		<?php if ((isset($_SESSION['GGID']))): ?> 
		<div class="alert alert-info text-center" role="alert">Bạn chỉ cần đăng ký một lần!<br/>Lần sau chỉ cần đăng nhập với Google mà không cần mật khẩu!</div>	 
		 <div class="form-group">
        	<div class="input-group">
                <span class="input-group-addon"><i class="fa fa-google"></i></span>	 
                <input type="number" class="form-control" readonly value="<?php echo $_SESSION['GGID']; ?>">			
            </div>
        </div>
		<?php endif ?>
		<?php if ((isset($_SESSION['ZLID']))): ?> 
		<div class="alert alert-info text-center" role="alert">Bạn chỉ cần đăng ký một lần!<br/>Lần sau chỉ cần đăng nhập với Zalo mà không cần mật khẩu!</div>	 
		 <div class="form-group">
        	<div class="input-group">
                <span class="input-group-addon"><i class="fa fa-zalo"><img src="https://i.imgur.com/T8l6pjE.png" width="15px"/></i></span>	 
                <input type="number" class="form-control" readonly value="<?php echo $_SESSION['ZLID']; ?>">			
            </div>
        </div>
		<?php endif ?>
        <div class="form-group">
        	<div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
				 <?php if ((isset($_SESSION['EMAIL2']))): ?> 
                <input type="text" class="form-control" name="email" placeholder="Email hoặc số điện thoại" maxlength="40" required="required" autocomplete="nope" value="<?php echo $_SESSION['EMAIL2']; ?>">
				<?php else: ?>
				<input type="text" class="form-control" name="email" placeholder="Email hoặc số điện thoại" maxlength="35" required="required" autocomplete="nope" >
				<?php endif ?>
            </div>
        </div>
		 <div class="form-group">
        	<div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
				 <?php if ((isset($_SESSION['FULLNAME']))): ?> 
                <input type="text" class="form-control" name="fullname" placeholder="Tên đầy đủ" autocomplete="nope" maxlength="30" required="required" value="<?php echo $_SESSION['FULLNAME']; ?>">
				<?php else: ?>
				<input type="text" class="form-control" name="fullname" placeholder="Tên đầy đủ" autocomplete="nope" maxlength="30" required="required">
				<?php endif ?>
			</div>
        </div>
		<div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control" name="password" id="password"  placeholder="Mật khẩu" autocomplete="new-password" required="required">
            </div>
        </div>
		<div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control" name="repassword" id="repassword" placeholder="Nhập lại mật khẩu" autocomplete="new-password" required="required">
            </div>
        </div>        		
        <div class="form-group">
            <button type="submit" name="submit" class="btn btn-success btn-block login-btn">Tiếp theo</button>
        </div>
        <div class="clearfix">
           <div class="text-center"> <label  id="note_ps"><?php echo $output; ?></label></div>	   
        </div>  
        
    </form>
    <div class="hint-text small">Bạn đã có tài khoản? <a href="/tai-khoan.html" class="text-success">Đăng nhập ngay!</a></div>
</div>

 <script type="text/javascript">

   function checkPassword(form) { 
                password1 = form.password.value; 
                password2 = form.repassword.value; 
  
                	if (typeof password1 == 'number') {
					document.getElementById('note_ps').innerHTML  = '<span class="text-warning">Mật khẩu không an toàn. <br/>Vui lòng thử lại...</span>';
					return false; 
					}
                  //else if (password1.length <12) {
				//	document.getElementById('note_ps').innerHTML  = '<span class="text-warning">Mật khẩu quá ngắn. Tối thiểu 12 kí tự. <br/>Vui lòng thử lại...</span>';
                  //  return false; 
				//	}
                // If Not same return False.     
                else if (password1 != password2) { 
                  //  alert ("\nCả hai mật khẩu không khớp. Vui lòng thử lại...") 
					document.getElementById('note_ps').innerHTML  = '<span class="text-warning">Mật khẩu không khớp. <br/>Vui lòng thử lại...</span>';
                    return false; 
                } 
  
                // If same return True. 
                else{ 
                    //alert("Password Match: Welcome to GeeksforGeeks!")
					return true; 
                    
                } 
            } 
    </script>