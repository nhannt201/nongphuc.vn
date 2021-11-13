<?php session_start(); 
	require_once './inl/ADMIN.php';
	require_once './inl/SEARCH_INC.php';
	$admin = new ADMIN();
	$tim = new SEARCH();
	if (isset($_SESSION['LOG'])) {
			if (isset($_SESSION['EMAIL'])) {
				if (isset($_SESSION['ADMIN'])) {
					if ($_SESSION['ADMIN'] == 0) {
							if (isset($_GET['method'])) {
							$vauluee=trim(addslashes($_GET['method']));
							echo $tim->showMember($vauluee);
							} 
					} else {
						echo '<script>window.location.replace("'.$domain_home.'");</script>';
						exit;
					}
				}
			} else {
				echo '<script>window.location.replace("'.$domain_home.'");</script>';
				exit;
			}
		
		
	} else {
		echo '<script>window.location.replace("'.$domain_home.'");</script>';
		exit;
	}

