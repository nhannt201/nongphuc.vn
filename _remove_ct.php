<?php session_start(); 
	require_once './inl/PROFILE.php';
	$profile = new PROFILE();
	if (isset($_SESSION['LOG'])) {
			if (isset($_SESSION['EMAIL'])) {
				$email = $_SESSION['EMAIL'];
					if (isset($_GET['method'])) {
						$vauluee=trim(addslashes($_GET['method']));
						$profile->deleteConnected($email, $vauluee);
						echo "a";
					} 
			} else {
				echo '<script>window.location.replace("'.$domain_home.'");</script>';
				exit;
			}
		
		
	} else {
		echo '<script>window.location.replace("'.$domain_home.'");</script>';
		exit;
	}

