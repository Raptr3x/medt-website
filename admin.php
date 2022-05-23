<?php
	require_once "./constants.php";
	require_once "./functions.php";
    $user = check_login();
?>
<!doctype html>
<html lang="en">
	<?php require_once TEMPLATES."/admin-head.php";?>
	<body class="has-sidebar has-fixed-sidebar-and-header side-nav-full-mode">
		<?php
		
		require_once TEMPLATES."/admin-menu.php";
		
		if(!isset($_GET['page'])){
			require_once TEMPLATES."/reservations.php";
		}else{
            switch ($_GET['page']) {
                case 'reservationen':
                    require_once TEMPLATES."/reservations.php";
                    break;
                default:
                    require_once NOTIFICATIONS."/404.php";
                    break;
            }
		}
		
		require_once TEMPLATES."/admin-footer.php";
		?>

	</body>
</html>