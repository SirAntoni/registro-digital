<aside id="sidebar-left" class="sidebar-left">

	<div class="sidebar-header">
		<div class="sidebar-title">
			Navegación
		</div>
		<div class="sidebar-toggle d-none d-md-block" data-toggle-class="sidebar-left-collapsed" data-target="html"
			data-fire-event="sidebar-left-toggle">
			<i class="fas fa-bars" aria-label="Toggle sidebar"></i>
		</div>
	</div>

	<div class="nano">
		<div class="nano-content">
			<nav id="menu" class="nav-main" role="navigation">

				<ul class="nav nav-main">
					<li <?php echo ($view === 'registros') ? 'class="nav-active nav-expanded"':''; ?>>
						<a class="nav-link" href="index?view=registros">
							<i class="bx bx-detail" aria-hidden="true"></i>
							<span>Registros</span>
						</a>
					</li>
					<?php if($_SESSION['rol'] === '1'){ ?>
						<li <?php echo ($view === 'usuarios' || $view === 'perfil') ? 'class="nav-active nav-expanded"':''; ?>>
							<a class="nav-link" href="index?view=usuarios">
								<i class="bx bx-group" aria-hidden="true"></i>
								<span>Usuarios</span>
							</a>
						</li>
					<?php }  ?>
				</ul>
			</nav>

		</div>

		<script>
			// Maintain Scroll Position
			if (typeof localStorage !== 'undefined') {
				if (localStorage.getItem('sidebar-left-position') !== null) {
					var initialPosition = localStorage.getItem('sidebar-left-position'),
						sidebarLeft = document.querySelector('#sidebar-left .nano-content');

					sidebarLeft.scrollTop = initialPosition;
				}
			}
		</script>

	</div>

</aside>