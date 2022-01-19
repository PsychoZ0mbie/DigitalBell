    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><a href="<?=base_url();?>/Usuarios/perfil"><img class="app-sidebar__user-avatar" src="<?= media();?>/images/uploads/avatar.png" alt="Avatar"></a>
        <div>
          <p class="app-sidebar__user-name"><?=$_SESSION['userData']['first_name'] ?></p>
          <p class="app-sidebar__user-designation"><?=$_SESSION['userData']['rolname'] ?></p>
        </div>
      </div>
      <ul class="app-menu">´
        <?php
          if(!empty($_SESSION['permisos'][1]['r'])){
        ?>
        <li><a class="app-menu__item" href="<?=base_url();?>/dashboard"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
        <?php
          }
        ?>
        <?php
          if(!empty($_SESSION['permisos'][2]['r'])||!empty($_SESSION['permisos'][3]['r'])){
        ?>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Usuarios</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
          <?php
          if(!empty($_SESSION['permisos'][2]['r'])){
          ?>
            <li><a class="treeview-item" href="<?=base_url();?>/usuarios"><i class="icon fa fa-circle-o"></i> Usuarios</a></li>
          <?php
          }
          ?>
          <?php
          if(!empty($_SESSION['permisos'][3]['r'])){
          ?>
            <li><a class="treeview-item" href="<?=base_url();?>/roles" rel="noopener"><i class="icon fa fa-circle-o"></i> Roles</a></li>
          <?php
          }
          ?>
          </ul>
        </li>
        <?php
          }
        ?>
        <?php
          if(!empty($_SESSION['permisos'][6]['r'])){
        ?>
        <li><a class="app-menu__item" href="<?=base_url();?>/categorias"><i class="app-menu__icon fa fa-tags"></i><span class="app-menu__label">Categorias</span></a></li>
        <?php
          }
        ?>
        <?php
          if(!empty($_SESSION['permisos'][4]['r'])){
        ?>
        <li><a class="app-menu__item" href="<?=base_url();?>/articulos"><i class="app-menu__icon fa fa-share-square"></i><span class="app-menu__label">Mi blog</span></a></li>
        <?php
          }
        ?>
        <?php
          if(!empty($_SESSION['permisos'][7]['r'])){
        ?>
        <li><a class="app-menu__item" href="<?=base_url();?>/suscripciones"><i class="app-menu__icon fa fa-newspaper-o"></i><span class="app-menu__label">Suscripciones</span></a></li>
        <?php
          }
        ?>
        <?php
          if(!empty($_SESSION['permisos'][8]['r'])){
        ?>
        <li><a class="app-menu__item" href="<?=base_url();?>/contacto"><i class="app-menu__icon fa fa-envelope"></i><span class="app-menu__label">Mensajes</span></a></li>
        <?php
          }
        ?>
        <li><a class="app-menu__item" href="<?= base_url();?>/logout"><i class="app-menu__icon fa fa-sign-out"></i><span class="app-menu__label">Cerrar sesión</span></a></li>
      </ul>
    </aside>