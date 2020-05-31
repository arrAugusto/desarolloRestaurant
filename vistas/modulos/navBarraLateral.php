<!-- /.navbar-top-links -->
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav in" id="side-menu">
            <?php
            if ($_SESSION["perfilUser"] == "Administrador" || $_SESSION["perfilUser"] == "Mesero") {
                echo '
                <li>
                    <a href="inicio" class="active"><i class="fa fa-dashboard fa-fw"></i> Inicio</a>
                </li>
                    ';

                if ($_SESSION["perfilUser"] == "Administrador") {
                    echo '
                    <li>
                        <a href="user"><i class="fa fa-user fa-fw"></i>Usuarios</a>
                    </li>
                    ';
                }
                echo '
            <li>
                <a href="nuevosPlatos"><i class="fa fa-cutlery fa-fw"></i>Opciones de Menús</a>
            </li>
            <li>
                <a href="gestorMesas"><i class="fa fa-cogs fa-fw"></i>Gestión de Mesas</a>
            </li>
            <li>
                <a href="historiaDeFacturas"><i class="fa fa-archive fa-fw"></i>Historial de Facturas</a>
            </li>
            ';
            }
            if ($_SESSION["perfilUser"] == "Cocinero") {
                echo '        
                <li>
                    <a href="inicio" class="active"><i class="fa fa-dashboard fa-fw"></i> Inicio</a>
                </li>
                <li>
                    <a href="nuevosPlatos"><i class="fa fa-cutlery fa-fw"></i>Opciones de Menús</a>
                </li>
                <li>
                    <a href="gestorMesas"><i class="fa fa-cogs fa-fw"></i>Gestión de Mesas</a>
                </li>

                ';
            }
            ?>
        </ul>
    </div>
</div>
</nav>
