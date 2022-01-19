
<!DOCTYPE html>
  <html lang="en">
  <head>
        
    <?php
      
      $empresa = NOMBRE_EMPRESA;
      $descripcion = DESCRIPCION;
      $titulo = NOMBRE_EMPRESA;
      $urlWeb = base_url();
      $urlImg = media()."/images/uploads/icono.png";
      if(!empty($data['post'])){
        //$descripcion = $data['post']['description'];
        $descripcion = DESCRIPCION;
        $titulo = $data['post']['title'];
        $urlImg = $data['post']['image'];
        $urlWeb = base_url()."/publicaciones/articulo/".$data['post']['idpost']."/".urlencode($data['post']['route']);
      }
    ?>
    <meta charset="utf-8">
    <meta name="description" content="<?=DESCRIPCION?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content ="David Parrado">
    <meta name="keywords" content="<?=KEYWORDS?>"/>
    <meta name = "theme-color" content="#009688">
    <link rel ="shortcut icon" href="<?= media();?>/images/uploads/icono.png" sizes="32x32" type="image/png">
    <meta name="author" content="<?=NOMBRE_EMPRESA?>" />
    <meta name="copyright" content="<?=NOMBRE_EMPRESA?>"/>
    <meta name="robots" content="index,follow" />
    <!--<meta http-equiv="cache-control" content="no-cache"/>-->
    <meta http-equiv="refresh" content="43200; <?=$urlWeb?>"/>
    <!--<meta http-equiv="expires" content="43200"/>-->
    
    <meta property="fb:app_id"          content="1234567890" /> 
    <meta property="og:locale" 		content='es_ES'/>
    <meta property="og:type"        content="article" />
    <meta property="og:site_name"	content="<?= $empresa; ?>"/>
    <meta property="og:description" content="<?= $descripcion; ?>"/>
    <meta property="og:title"       content="<?= $titulo; ?>" />
    <meta property="og:url"         content="<?= $urlWeb; ?>" />
    <meta property="og:image"       content="<?= $urlImg; ?>" />
    <meta name="twitter:card" content="summary"></meta>
    <meta name="twitter:site" content="<?= $urlWeb; ?>"></meta>
    <meta name="twitter:creator" content="<?= NOMBRE_EMPRESA; ?>"></meta>
    
    <link rel="canonical" href="<?= $urlWeb?>"/>
    <title><?= $data['page_tag'];?></title>
    <!-- Main CSS-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="<?= media();?>/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Spartan:wght@300;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?= media();?>/css/normalize.css?n=1">
    <link rel="stylesheet" type="text/css" href="<?= media();?>/css/util.css?n=1">
    <link rel="stylesheet" type="text/css" href="<?= media();?>/css/style.css?n=1">
    <!--<script async custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/amp-iframe-0.1.js"></script>-->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-005QPDLDS1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-005QPDLDS1');
    </script>
  </head>
  <body class="app sidebar-mini">
      <?php //require_once("Views/Template/Modals/modalSesion.php");
            getModal('modalSesion',$data);
        ?>
    <div id="divLoading">
        <img src="<?= media();?>/images/loading/loading.svg" alt="Loading">
    </div>
    <!-- Navbar-->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand logo" href="<?=base_url();?>"><?=NOMBRE_EMPRESA?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
              <div class="navbar-nav text-center ml-auto">
                <a class="nav-link text-white" href="<?=base_url();?>">Inicio</a>
                <a class="nav-link text-white" href="<?=base_url();?>/publicaciones/categorias">Categorias</a>
                <a class="nav-link text-white" href="<?=base_url();?>/publicaciones/Contacto">Contacto</a>
                <a class="nav-link text-white" href="<?=base_url();?>/publicaciones/mas">Más</a>
                <?php 
                  if(isset($_SESSION['login'])){     
                ?>
                <li class="nav-item dropdown cuenta">
                  <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Mi cuenta
                  </a>
                  <div class="dropdown-menu bg-dark text-center" aria-labelledby="navbarDropdown">
                    <?php 
                      if($_SESSION['userData']['idrol'] != 3){
                    ?>
                    <a class="dropdown-item" href="<?=base_url();?>/Dashboard">Dashboard</a>
                    <?php }?>
                    <a class="dropdown-item" href="<?=base_url();?>/Usuarios/perfil">Perfil</a>
                    <a class="dropdown-item" href="<?=base_url();?>/CerrarSesion">Cerrar sesión</a>
                  </div>
                </li>
                <?php }else{ ?>
                <button class="nav-link text-info btn-comment" type="button">Inicia sesión o Regístrate</button> 
                <?php }?>
              </div>
            </div>
         </nav>
    </header>
    