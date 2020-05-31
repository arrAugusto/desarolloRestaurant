<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    

    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>

    <ul class="nav navbar-nav navbar-left navbar-top-links">
<div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="<?php if ($_SESSION["foto"]=="") {
    echo 'vistas/img/usuarios/default/anonymous.png';
}else{
    echo $_SESSION["foto"];
}
?>" width="20px;" class="img-circle elevation-3" alt="User Image">
          <a href="#" class="d-block" style="color: #fff;"><?php echo $_SESSION["nombreUser"];?></a>
          
        </div>
      </div>
    </ul>

    <ul class="nav navbar-right navbar-top-links">

        <li class="dropdown">
            <a class="dropdown-toggle" href="salir">
                <i class="fa fa-power-off fa-fw"></i> Cerrar Sessión </a>

        </li>
    </ul>
