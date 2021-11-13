<?php
require_once './inl/LOCATION.php'; 
$loc =  new LOCATION();
require_once './inl/DB.php';
$newDB = new DB();
if (isset($_SESSION['ADMIN'])) { //chi cho admin tim kiem
				if ($_SESSION['ADMIN'] == 0) { 
				
				} else {
					echo '<script>window.location.replace("'.$domain_home.'");</script>';
					exit;
				}
} else {
	echo '<script>window.location.replace("'.$domain_home.'");</script>';
				exit;
}
//Tren day de kiem tra dau vao
if (isset($_GET['tinh_tp'])) {
	if (isset($_GET['quan_huyen'])) {
		if (isset($_GET['phuong_xa'])) {
			if (isset($_GET['nongpham'])) {
				$nongpham = trim(htmlspecialchars($_GET['nongpham']));
				if (!is_numeric($nongpham)) {
					echo '<script>window.location.replace("'.$domain_home.'");</script>';
					exit;
				} else {
					//Xu li code ben duoi kia
				}
				
			} else {
				echo '<script>window.location.replace("'.$domain_home.'");</script>';
				exit;
			}
		} else {
			echo '<script>window.location.replace("'.$domain_home.'");</script>';
			exit;
		}
	} else {
		echo '<script>window.location.replace("'.$domain_home.'");</script>';
		exit;
	}
} else {
	echo '<script>window.location.replace("'.$domain_home.'");</script>';
	exit;
}

?>
<div class="container">
<article>
<div class="row">
<!--Left-->
<div class="col-md-3">
<!--Panel Search-->
<div class="panel panel-default">
<div class="list-group-item activeCS">
Công cụ tìm kiếm dành cho Admin
</div>

<div class="list-group-item">
<form method="get" action="/search-vip" id="searchForm" class="searchForm">
<select class="form-control" name="tinh_tp" id="tinh_tp" onchange="clickProvince()">
<option value="0">--Tỉnh/Thành phố--</option>
<?php if (isset($_GET['tinh_tp'])) {
	$tinh = trim(htmlspecialchars($_GET['tinh_tp'])); if ($tinh == 0) {} else {
		//Check tinh truoc
		if ($loc->checkTinh($tinh)) {
			echo '<option value="'.$tinh.'" selected>'.$loc->getTinh($tinh).'</option>';
		} else {
			//Redict home
			echo '<script>window.location.replace("'.$domain_home.'");</script>';
			exit;
		}
	}
} ?>

<?php
$newDB->showProvince();
?>
</select><br/>
<select class="form-control" name="quan_huyen" id="quan_huyen" onchange="clickDistrict()">
<option value="0">--Quận/Huyện--</option>
<?php if (isset($_GET['quan_huyen'])) {
	$huyen = trim(htmlspecialchars($_GET['quan_huyen'])); if ($huyen == 0) {} else {
		//Check huyen co hay ko
		if ($loc->checkHuyen($huyen)) {
			echo '<option value="'.$huyen.'" selected>'.$loc->getHuyen($huyen).'</option>';
		} else {
			echo '<script>window.location.replace("'.$domain_home.'");</script>';
			exit;
		}
	}
} ?>
</select><br/>
<select class="form-control" name="phuong_xa" id="phuong_xa">
<option value="0">--Xã/Phường/Thị Trấn--</option>
<?php if (isset($_GET['phuong_xa'])) {
	$xa = trim(htmlspecialchars($_GET['phuong_xa'])); if ($xa == 0) {} else {
		//Check xa co k 
		if ($loc->checkXa($xa)) {
			echo '<option value="'.$xa.'" selected>'.$loc->getXa($xa).'</option>';
		} else {
			echo '<script>window.location.replace("'.$domain_home.'");</script>';
			exit;
		}
	}
} ?>
</select><br/>
<!--<div class="form-group">
  <input type="text" name="tk" id="tk" class="form-control" placeholder="Tên sản phẩm (nếu có)">
</div>-->
<select class="form-control" name="nongpham" id="nongpham">
<option value="0">--Tất cả--</option>
<?php
require_once './inl/DB.php';
$newDB = new DB();
$newDB->showNongSan();
if (isset($_GET['nongpham'])) {
	$nongphamm = trim(htmlspecialchars($_GET['nongpham']));
	if ($nongphamm == 0) { } else {
		if (strlen($nongphamm) < 1000000) {//nho hon 1 trieu thi ok
				echo '<option value="'.$nongphamm.'" selected>'.$newDB->showNameNongSan($nongphamm).'</option>';
		} else {
			echo '<script>window.location.replace("'.$domain_home.'");</script>';
			exit;
		}
	}
			}
?>
</select><br/>
<div class="text-right">
	 <button type="submit" class="btn btn-success btn-sm">Tìm kiếm</button></div>
</div>
</form>
</div>
  <!--JS_XL-->
 <script type="text/javascript" src="/js/jquery.qq.js"></script>

<?php require_once './inl/ADS.php';
		$getADS = new ADS();
		if ($getADS->GetADS("ads2")):
		?>
		<!--Panel Ads-->
		<div class="panel panel-default" id="ads-cndai">
		<a href="<?php echo $getADS->GetADS("ads2_link"); ?>" target="_blank"><img src="<?php echo $getADS->GetADS("ads2"); ?>" width="100%"/></a>
		</div>
		<?php endif ?>

</div>

<!--Nam vao vung can le phai-->
<div class="col-md-9">

<?php require_once './inl/ADS.php';
		$getADS = new ADS();
if ($getADS->GetADS("ads3")): ?>
		<!--Panel Ads Hoz-->
		<div class="panel panel-default" id="ads-right">
		<a href="<?php echo $getADS->GetADS("ads3_link"); ?>" target="_blank"><img src="<?php echo $getADS->GetADS("ads3"); ?>" width="100%"/></a>
		</div>
		<?php endif ?>
<!--Newfeed-->
<div class="panelCS panel-custom">
  <div class="panel-heading">Bài viết tìm thấy</div>

<div class="panel-body">

<div class="panelCS panel-custom" id="content">

<?php
if (isset($_GET['tinh_tp'])) {
	if (isset($_GET['quan_huyen'])) {
		if (isset($_GET['phuong_xa'])) {
			if (isset($_GET['nongpham'])) {
				$tinh_tp = trim(htmlspecialchars($_GET['tinh_tp']));
				$quan_huyen = trim(htmlspecialchars($_GET['quan_huyen']));
				$phuong_xa = trim(htmlspecialchars($_GET['phuong_xa']));
				$nongpham = trim(htmlspecialchars($_GET['nongpham']));
				if (!is_numeric($nongpham)) {
					echo '<script>window.location.replace("'.$domain_home.'");</script>';
					exit;
				} else {
					require_once './inl/SEARCH_INC.php';
					$show_kq = new SEARCH();
					$show_kq->showThreadPro($tinh_tp, $quan_huyen, $phuong_xa, $nongpham);
				}
				
			} else {
				echo '<script>window.location.replace("'.$domain_home.'");</script>';
				exit;
			}
		} else {
			echo '<script>window.location.replace("'.$domain_home.'");</script>';
			exit;
		}
	} else {
		echo '<script>window.location.replace("'.$domain_home.'");</script>';
		exit;
	}
} else {
	echo '<script>window.location.replace("'.$domain_home.'");</script>';
	exit;
}

?>

</div>
 <script type="text/javascript">
 var count =0;
window.onscroll = function(ev) {
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
		count++;
		var x = document.getElementById("show" + count);
		if (x) {
			x.style.display = "block";
		}
		
    }
};

 </script>
</div>
</div>
</article>
</div>