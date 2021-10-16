
<!DOCTYPE html>
<html lang="en">
<?php
    define('MAX_TIME', 3600*2);
    if(isset($_SESSION['time']) && (time()-$_SESSION['time']>MAX_TIME)){
        destruir_session();
    }
    $_SESSION['time'] = time();
    function destruir_session() {

      $_SESSION = array();
      if ( ini_get( 'session.use_cookies' ) ) {
          $params = session_get_cookie_params();
          setcookie(
              session_name(),
              '',
              time() - MAX_TIME,
              $params[ 'path' ],
              $params[ 'domain' ],
              $params[ 'secure' ],
              $params[ 'httponly' ] );
      }
  
      header('Location: '.base_url());
  }
?>
  <head>
    <meta name="description" content="<?=DESCRIPCION?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content ="David Pg">
    <meta name = "theme-color" content="#009688">
    <link rel ="shortcut icon" href="<?= media();?>/images/uploads/icono.png">
    <title><?= $data['page_tag'];?></title>
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?= media();?>/css/main.css?n=1">
    <link rel="stylesheet" type="text/css" href="<?= media();?>/css/normalize.css?n=1">
    <link rel="stylesheet" type="text/css" href="<?= media();?>/css/bootstrap-select.min.css?n=1">
    <link rel="stylesheet" type="text/css" href="<?= media();?>/css/jquery.maxlength.css?n=1">
    <link rel="stylesheet" type="text/css" href="<?= media();?>/css/style.css?n=1">
    <!-- Font-icon css-->
    <link rel="stylesheet" href="<?= media();?>/css/font-awesome.min.css?n=1">
  </head>
  <body class="app sidebar-mini">
    <div id="divLoading">
        <img src="<?= media();?>/images/loading/loading.svg" alt="Loading">
    </div>
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="<?=base_url();?>"><?=NOMBRE_EMPRESA?></a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <!--<li><a class="dropdown-item" href="<?=base_url();?>/opciones"><i class="fa fa-cog fa-lg"></i> Opciones</a></li>-->
            <li><a class="dropdown-item" href="<?=base_url();?>/Usuarios/perfil"><i class="fa fa-user fa-lg"></i> Perfil</a></li>
            <li><a class="dropdown-item" href="<?=base_url();?>/logout"><i class="fa fa-sign-out fa-lg"></i> Cerrar sesión</a></li>
          </ul>
        </li>
      </ul>
    </header>
    <?php require_once("nav_admin.php");?>