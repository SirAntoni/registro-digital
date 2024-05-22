<?php
session_start();

if (!isset($_SESSION['id']))
	header("Location:login");

if (isset($_GET['view']) && $_GET['view'] === 'usuarios' && $_SESSION['rol'] !== '1')
	header("Location:logout");

?>
<!doctype html>
<html class="fixed sidebar-left-xs">

<head>

	<!-- Basic -->
	<meta charset="UTF-8">

	<title>Registro Digital | CIA 21</title>

	<meta name="keywords" content="HTML5 Admin Template" />
	<meta name="description" content="Porto Admin - Responsive HTML5 Template">
	<meta name="author" content="okler.net">

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />

	<!-- AJAX -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


	<!-- Web Fonts  -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800|Shadows+Into+Light"
		rel="stylesheet" type="text/css">

	<!-- Vendor CSS -->
	<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" href="vendor/animate/animate.compat.css">
	<link rel="stylesheet" href="vendor/font-awesome/css/all.min.css" />
	<link rel="stylesheet" href="vendor/boxicons/css/boxicons.min.css" />
	<link rel="stylesheet" href="vendor/magnific-popup/magnific-popup.css" />
	<link rel="stylesheet" href="vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css" />
	<link rel="stylesheet" href="vendor/select2/css/select2.css" />
	<link rel="stylesheet" href="vendor/select2-bootstrap-theme/select2-bootstrap.min.css" />
	<link rel="stylesheet" href="vendor/datatables/media/css/dataTables.bootstrap5.css" />
	<link rel="stylesheet" href="vendor/bootstrap-fileupload/bootstrap-fileupload.min.css" />


	<!-- Theme CSS -->
	<link rel="stylesheet" href="css/theme.css" />

	<!-- Skin CSS -->
	<link rel="stylesheet" href="css/skins/default.css" />

	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="css/custom.css">

	<!-- Head Libs -->
	<script src="vendor/modernizr/modernizr.js"></script>

</head>

<body>
	<section class="body">

		<!-- start: header -->
		<?php require './includes/header.php' ?>
		<!-- end: header -->

		<div class="inner-wrapper">
			<?php $view = $_GET['view']; ?>
			<!-- start: sidebar -->
			<?php require './includes/sidebar-left.php' ?>
			<!-- end: sidebar -->

			<section role="main" class="content-body">

				<?php require './includes/navbar.php' ?>



				<!-- start: page -->

				<?php

				switch ($view) {
					case "registros":
						require './views/Registro.php';
						break;
					case "usuarios":
						require './views/Usuario.php';
						break;
					case "perfil":
						require './views/Perfil.php';
						break;
					case "documento":
						require './views/Documento.php';
						break;
					default:
						require './views/Registro.php';
						break;
				}

				?>
				<!-- end: page -->
			</section>
		</div>
	</section>

	<!-- Vendor -->
	<script src="vendor/jquery/jquery.js"></script>
	<script src="vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
	<script src="vendor/popper/umd/popper.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="vendor/common/common.js"></script>
	<script src="vendor/nanoscroller/nanoscroller.js"></script>
	<script src="vendor/magnific-popup/jquery.magnific-popup.js"></script>
	<script src="vendor/jquery-placeholder/jquery.placeholder.js"></script>

	<!-- Specific Page Vendor -->

	<!-- Theme Base, Components and Settings -->
	<script src="js/theme.js"></script>


	<!-- Theme Custom -->
	<script src="js/custom.js"></script>

	<!-- Theme Initialization Files -->
	<script src="js/theme.init.js"></script>

	<!-- Specific Page Vendor -->
	<script src="vendor/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<!-- Theme Base, Components and Settings -->
	<script src="js/theme.js"></script>

	<!-- Theme Custom -->
	<script src="js/custom.js"></script>
	<script src="js/app.js"></script>
	<script src="js/modals.js"></script>

</body>

</html>