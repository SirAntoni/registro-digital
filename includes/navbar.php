<header class="page-header">
	<?php switch ($view) {
		case "registros":
			echo "<h2>Registros</h2>";
			break;
		case "usuarios":
			echo "<h2>Usuarios</h2>";
			break;
		default:
			echo "<h2></h2>";
			break;
	} ?>


	<div class="right-wrapper text-end">
		<ol class="breadcrumbs">
			<li>
				<a href="index?view=registros">
					<i class="bx bx-home-alt"></i>
				</a>
			</li>

			<?php switch ($view) {
				case "registros":
					echo "<li><span>Registros</span></li>";
					break;
				case "usuarios":
					echo "<li><span>Usuarios</span></li>";
					break;
				default:
					echo "<li><span>Home</span></li>";
					break;
			} ?>

			

		</ol>

	</div>
</header>