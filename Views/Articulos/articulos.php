<?php headerAdmin($data);?> 
<main class="app-content">

<?php
    getModal('modalArticulos',$data);
    if(empty($_SESSION['permisosMod']['r'])){
?>
    <p>Acceso denegado</p>

    <?php 
    }else{?>
      <div class="app-title">
        <div>
            <h1><i class="fa fa-share-square"></i> <?= $data['page_title'] ?>
              <?php if($_SESSION['permisosMod']['w']){?>
                <button class="btn btn-primary" type="button" onclick="openModal();" ><i class="fas fa-plus-circle"></i> Crear artículo</button>
              <?php }?>  
            </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>/articulos"><?= $data['page_title'] ?></a></li>
        </ul>
      </div>
        <div class="row">
            <div class="col-md-12">
              <div class="tile">
                <div class="tile-body">
                  <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="tableArticulos">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Título</th>
                          <th>Autor</th>
                          <th>Categoría</th>
                          <th>Status</th>
                          <th>Fecha</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <?php }?>
    </main>
<?php footerAdmin($data); ?>
    