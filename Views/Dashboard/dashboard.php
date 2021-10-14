
<?php headerAdmin($data);?>
<main class="app-content">
<?php
  if(empty($_SESSION['permisosMod']['r'])){
?>
  <p>Acceso denegado</p>
    <?php
      }else{?>
    
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> <?= $data['page_title'];?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?=base_url();?>/dashboard">Dashboard</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-6 col-lg-3">
          <div class="widget-small primary coloured-icon"><a class="text-decoration-none" href="<?=base_url();?>/usuarios"><i class="icon fa fa-users fa-3x"></i></a>
            <div class="info">
              <h4>Usuarios</h4>
              <p><b><?=$data['usuarios']?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small info coloured-icon"><a class="text-decoration-none" href="<?=base_url();?>/articulos"><i class="icon fa fa-share-square"></i></a>
            <div class="info">
              <h4>Artículos</h4>
              <p><b><?=$data['articulos']?></b></p>
            </div>
          </div>
        </div>
        <?php
            if($_SESSION['idUser'] == 1){
        ?>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small warning coloured-icon"><a class="text-decoration-none" href="<?=base_url();?>/suscripciones"><i class="icon fa fa-newspaper-o"></i></a>
            <div class="info">
              <h4>Suscripciones</h4>
              <p><b><?=$data['suscripciones']?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small danger coloured-icon"><a class="text-decoration-none" href="<?=base_url();?>/contacto"><i class="icon fa fa-envelope"></i></a>
            <div class="info">
              <h4>Mensajes</h4>
              <p><b><?=$data['contactos']?></b></p>
            </div>
          </div>
        </div>
        <?php
            }
        ?>
      </div>
      <?php
        }
      ?>
    </main>
    <?php footerAdmin($data);?>