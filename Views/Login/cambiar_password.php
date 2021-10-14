<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="David Parrado">
    <meta name="theme-color" content="#009688">
    <link rel ="shortcut icon" href="<?= media();?>/images/uploads/img/Icono.png">
    <title><?= $data['page_tag'];?></title>
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?= media();?>/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?= media();?>/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="<?= media();?>/css/style.css">

  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <!--<div class="logo">
      <img src="<?= media();?>/images/uploads/img/logotipo.png" width=300px height=200px alt="Logotipo">
      </div>-->
      <div class="login-box flipped">
        <div id="divLoading">
          <div>
            <img src="<?= media();?>/images/uploads/img/loading.svg" alt="Loading">
          </div>
        </div>
        <form id="formCambiarPass" name="formCambiarPass" class="forget-form" action="">
            <input type="hidden" id="idUsuario" name="idUsuario" value="<?= $data['id_person'];?>" required>
            <input type="hidden" id="txtEmail" name="txtEmail" value="<?= $data['email'];?>" required>
            <input type="hidden" id="txtToken" name="txtToken" value="<?= $data['token'];?>" required>
          <h3 class="login-head">Cambiar contraseña</h3>
          <div class="form-group">
            <input id="txtPassword" name="txtPassword" class="form-control" type="password" placeholder="Nueva contraseña" required>
            <input id="txtPasswordConfirm" name="txtPasswordConfirm" class="form-control" type="password" placeholder="Confirmar contraseña" required>  
        </div>
          <div class="form-group btn-container">
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>REINICIAR</button>
          </div>
          <div class="form-group mt-3">
            <p class="semibold-text mb-0"><a href="<?= base_url();?>/login" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Iniciar sesión</a></p>
          </div>
        </form>
        
      </div>
    </section>
    <script>
        const base_url = "<?= base_url(); ?>";
    </script>
    <!-- Essential javascripts for application to work-->
    <script src="<?= media(); ?>/js/jquery-3.3.1.min.js"></script>
    <script src="<?= media(); ?>/js/popper.min.js"></script>
    <script src="<?= media(); ?>/js/bootstrap.min.js"></script>
    <script src="<?= media();?>/js/fontawesome.js"></script>
    <script src="<?= media(); ?>/js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="<?= media(); ?>/js/plugins/pace.min.js"></script>
    <script type="text/javascript" src="<?= media(); ?>/js/plugins/sweetalert.min.js"></script>
    <script src="<?= media(); ?>/js/<?= $data['page_functions'];?>"></script>
  </body>
</html>