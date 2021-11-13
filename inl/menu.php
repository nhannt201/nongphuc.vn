<?php require_once './inl/ADMIN.php';
$admin = new ADMIN();
if (isset($_SESSION['EMAIL'])) { //Kiem tra email ton tai chua
	$email = $_SESSION['EMAIL'];
	$admin->CheckAdminMod($email);
} 
if (isset($_SESSION['PHONE'])) { //Kiem tra email ton tai chua
	$email = $_SESSION['PHONE'];
	$admin->CheckAdminMod($email);
}?>
<!-- Static navbar -->
    <nav class="navbar navbar-custom navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
		   <a class="navbar-brand" href="/"><?php echo $admin->GetSEO("webname"); ?></a>
		   		   <?php
		require_once './inl/functions.php'; 
		if (isMobile()) {
		   ?>
		    <?php if ((isset($_SESSION['LOG']))): ?> 
		   <!--Menu khi tren DT-->
			  <a  href="/dang-bai.html" class="navbar-brand">Đăng bài</a>
		   <!--end menu-->
		<?php else: ?> 
				   <!--Menu khi tren DT-->
			  
					<?php if (strpos($_SERVER['REQUEST_URI'], 'tai-khoan-moi') !== false): ?>
						<a class="navbar-brand" href="/tai-khoan.html#login">Đăng nhập</a>
						<?php elseif (strpos($_SERVER['REQUEST_URI'], 'tai-khoan') !== false): ?>
						<a class="navbar-brand" href="/tai-khoan-moi.html#newmember">Đăng ký</a>
						<?php else: ?>
						<a class="navbar-brand" href="/tai-khoan.html#login">Đăng nhập</a>
					<?php endif ?>
		   <!--end menu-->
		   <?php endif ?> 
		<?php } ?>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <!--<li ><a href="/"><span class="glyphicon glyphicon-home"></span>Trang chủ</a></li>-->
			 <?php if ((isset($_SESSION['LOG']))): ?>      <!--  After user login  -->
		    <li class="active"><a>Xin chào, <b><?php echo $_SESSION['FULLNAME']; ?></b></a></li>
			<?php else: ?>
			<li><a href="/#about">Giới thiệu</a></li>
			<?php endif ?>
			<?php if (strpos($_SERVER['REQUEST_URI'], 'tai-khoan') == false): ?>
			<!--<li><a href="/#about">Giới thiệu</a></li>-->
			<!--<li><a href="/#contact">Liên hệ</a></li>-->
			<?php endif ?>
            <!--<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>-->
          </ul>
          <ul class="nav navbar-nav navbar-right">
		   <?php if ((isset($_SESSION['LOG']))): ?>      <!--  After user login  -->
		    <li><a href="/tai-khoan.html">Trang cá nhân</a></li>
			<?php if (isset($_SESSION['ADMIN'])) {
				if ($_SESSION['ADMIN'] == 0) { ?>
					<li><a href="/trang-quan-tri.html">Trang quản trị</a></li>
					<li><a href="/kiem-duyet-vien.html">Trang kiểm duyệt</a></li>
					<?php }
					if ($_SESSION['ADMIN'] == 1) { ?>
						<li><a href="/kiem-duyet-vien.html">Trang kiểm duyệt</a></li>
					<?php }
			}?>
			<li><a href="/dang-bai.html">Đăng bài</a></li>
			<li><a href="/dang-xuat.html">Đăng xuất</a></li>
		   <?php else: ?>     <!-- Before login --> 
            <li><a href="/tai-khoan.html#login">Đăng nhập</a></li>
            <li><a href="/tai-khoan-moi.html#newmember">Đăng ký</a></li>
			<?php endif ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>