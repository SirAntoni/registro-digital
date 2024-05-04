<header class="header">
    <div class="logo-container">
        <a href="../4.2.0" class="logo">
            <img src="img/logo-e.png" height="35" alt="Porto Admin" />
        </a>

        <div class="d-md-none toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html"
            data-fire-event="sidebar-left-opened">
            <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
        </div>

    </div>

    <!-- start: search & user box -->
    <div class="header-right">


        <span class="separator"></span>

        <div id="userbox" class="userbox">
            <a href="#" data-bs-toggle="dropdown">
                <figure id="imgHeader" class="profile-picture">
                    
                </figure>

                <div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@okler.com">
                    <span id="nameHeader" class="name"></span>
                    <span id="rolHeader" class="role"></span>
                </div>

                <i class="fa custom-caret"></i>
            </a>

            <div class="dropdown-menu">
                <ul class="list-unstyled mb-2">
                    <li class="divider"></li>
                    <li>
                        <a role="menuitem" tabindex="-1" href="index?view=perfil"><i
                                class="bx bx-user-circle"></i> Mi perfil</a>
                    </li>
                    <li>
                        <a id='logout' role="menuitem" tabindex="-1" href="#"><i class="bx bx-power-off"></i>
                            Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- end: search & user box -->
</header>