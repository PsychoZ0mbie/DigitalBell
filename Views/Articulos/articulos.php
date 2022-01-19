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
            <h1><i class="fa fa-share-square"></i> <?= $data['page_title'] ?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>/articulos"><?= $data['page_title'] ?></a></li>
        </ul>
      </div>
      <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link active" id="pills-articles-tab" data-toggle="pill" href="#pills-articles" role="tab" aria-controls="pills-articles" aria-selected="true">Articulos</a>
        </li>
        <?php if($_SESSION['permisosMod']['w']){?>
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="pills-make-tab" data-toggle="pill" href="#pills-make" role="tab" aria-controls="pills-make" aria-selected="false">Crear Articulo</a>
        </li>
        <?php }?>  
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="pills-paper-tab" data-toggle="pill" href="#pills-paper" role="tab" aria-controls="pills-paper" aria-selected="false">Papelera</a>
        </li>
      </ul>
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-articles" role="tabpanel" aria-labelledby="pills-articles-tab">
          <div class="row">
              <div class="col-md-12">
                <div class="tile">
                  <div class="tile-body">
                    <div class="table-responsive">
                      <table class="table table-hover table-bordered w-100" id="tableArticulos">
                        <thead>
                          <tr>
                            <th>Título</th>
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
        </div>
        <div class="tab-pane fade" id="pills-make" role="tabpanel" aria-labelledby="pills-make-tab">
          <form id="formArticulo" name="formArticulo" class="form-horizontal" novalidate>
            <input type="hidden" id="idArticulo" name="idArticulo" value="">
            <div class="row">
              <div class="col-md-12">
                <div class="row">
                  <div class="form-group col-md-12">
                    <label class="control-label">Título corto (30 carácteres)</label>
                    <input class="form-control" id="txtNombre" name="txtNombre" type="text" required="">
                  </div>
                  <div class="form-group col-md-12">
                    <label class="control-label">Título (70 carácteres)<span class="text-secondary"> opcional</span></label>
                    <input class="form-control" id="txtTitulo" name="txtTitulo" type="text">
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-6">
                      <label for = "listCategoria">Categoría <span class="required"></span></label>
                      <select name="listCategoria" id="listCategoria" class="form-control" required="" data-live-search="true"></select>
                  </div>
                  <div class="form-group col-md-6">
                      <label for="listStatus">Estado <span class="required"></span></label>
                      <select class="form-control selectpicker" id="listStatus" name="listStatus" required="">
                        <option value="2">Inactivo</option>    
                        <option value="1">Activo</option>  
                      </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label">Descripción <span class="required">*</span></label>
                  <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="4"></textarea>
                </div>
                <div class="row">
                  <div class="form-group col-md-6 d-none" id="make">
                    <label class="control-label"><span><i class="fas fa-tag"></i> Crea tu etiqueta</span></label>
                    <div class="input-group-prepend">
                      <input type="text" id="txtTag" name="txtTag" class="form-control" placeholder="Escribe tu etiqueta" aria-label="Escribe tu etiqueta" aria-describedby="button-addon2">
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="btnTag"><i class="fas fa-plus"></i></button>
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-md-6 d-none" id="list">
                      <label for = "listTag"><span><i class="fas fa-tags"></i> Lista de etiquetas</span></label>
                      <select name="listTag" id="listTag" class="form-control" data-live-search="true"></select>
                  </div>
                </div> 
                <div class="form-group col-md-12">
                  <div id="containerTags"></div>
                </div>   
                <hr>
                <div class="form-group col-md-12">
                  <div id="containerGallery" >
                    <span><i class="fas fa-images"></i> Agrega tus fotos</span>
                    <button class="btnAddImage btn btn-outline-secondary btn-sm" type="button">
                        <i class="fas fa-plus"></i>
                    </button>
                  </div>
                </div> 
                <hr>
                <div id="containerImages"></div>   
              </div>
              <div class="col-md-12 mt-4">
                <button id="btnActionForm" class="btn btn-primary btn-lg btn-block" type="submit"><span id="btnText">Guardar</span></button>
                <button id ="btnCancel" class="btn btn-danger btn-lg btn-block" onclick="location.reload()" type="button" data-dismiss="modal">Cancelar</button>
              </div>
            </div>
          </form>
        </div>
        <div class="tab-pane fade" id="pills-paper" role="tabpanel" aria-labelledby="pills-paper-tab">
          <div class="row">
              <div class="col-md-12">
                <div class="tile">
                  <div class="tile-body">
                    <div class="table-responsive">
                      <table class="table table-hover table-bordered w-100" id="tablePaper">
                        <thead>
                          <tr>
                            <th>Título</th>
                            <th>Categoría</th>
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
        </div>
      </div>
        
        <?php }?>
    </main>
<?php footerAdmin($data); ?>
    