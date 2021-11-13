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
} else {
	//Xoa session cu neu chua dang nhap
	session_unset();
}
if (isset($_POST['sblog'])) {
	$email = trim(htmlspecialchars($_POST['email']));
	$password = $_POST['password'];
	$newmem = new DB();
	if ($newmem->mailCheck($email)) {
		if ($newmem->LoginCheck($email, md5($password))) {
		$_SESSION['LOG'] = 1;
		$newmem->GetSession($email);
		echo '<script>window.location.replace("'.$domain_home.'");</script>';
		} else {
			$output = '<span class="text-warning">Mật khẩu không đúng <br/>Vui lòng thử lại...</span>';
		}
	} else {
		$output = '<span class="text-warning">Tài khoản không tồn tại <br/>Vui lòng thử lại...</span>';
	}
}
?>
<div class="login-form">
    <form action="/tai-khoan.html" method="post">
        <h2 class="text-center">Đăng nhập</h2>		
        <div class="text-center social-btn">
            <a href="/login-facebook.html" class="btn btn-primary btn-block"><i class="fa fa-facebook"></i> Đăng nhập với <b>Facebook</b></a>
            <a href="/login-zalo.html" class="btn btn-info btn-block"><i class="fa fa-zalo"><img src="https://i.imgur.com/T8l6pjE.png" width="15px"/></i> Đăng nhập với <b>Zalo</b></a>
			<a href="/login-google.html" class="btn btn-danger btn-block"><i class="fa fa-google"></i> Đăng nhập với <b>Google</b></a>
        </div>
		<div class="or-seperator"><i>hoặc</i></div>
        <div class="form-group">
        	<div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input type="text" class="form-control" name="email" placeholder="Email hoặc số điện thoại" maxlength="40" required="required">
            </div>
        </div>
		<div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control" name="password" placeholder="Mật khẩu" required="required">
            </div>
        </div>        
        <div class="form-group">
            <button type="submit" name="sblog" class="btn btn-success btn-block login-btn">Đăng nhập</button>
        </div>
		<div class="clearfix">
           <div class="text-center"> <label  id="note_ps"><?php echo $output; ?></label></div>	   
        </div> 
        <!--<div class="clearfix">
            <label class="pull-left checkbox-inline"><input type="checkbox"> Ghi nhớ đăng nhập</label>
            <a href="#" class="pull-right text-success">Quên mật khẩu?</a>
        </div>  -->
        
    </form>
    <div class="hint-text small">Bạn chưa có tài khoản? <a href="/tai-khoan-moi.html" class="text-success">Đăng ký thành viên ngay!</a></div>
</div>