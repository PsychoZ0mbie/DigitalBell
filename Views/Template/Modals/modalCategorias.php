<!-- Modal -->
<div class="modal fade" id="modalFormCategorias" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nueva Categoria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formCategoria" name="formCategoria" class="form-horizontal">
              <input type="hidden" id="idCategoria" name="idCategoria" value="">
              <!--<input type="hidden" id="foto_actual" name="foto_actual" value="">
              <input type="hidden" id="foto_remove" name="foto_remove" value="0">-->

              <p class="text-primary">Los campos con asterisco (<span class="required">*</span>)son obligatorios.</p>
              <div class="row">
                <div class="col-md-6">

                    <div class="form-group">
                      <label class="control-label">Nombre <span class="required">*</span></label>
                      <input class="form-control" id="txtNombre" name="txtNombre" type="text" placeholder="Nombre" required="">
                    </div>
                    <div class="form-group">
                      <label class="control-label">Descripción <span class="required">*</span></label>
                      <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="2" placeholder="Descripción" required=""></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleSelect1">Estado <span class="required">*</span></label>
                        <select class="form-control selectpicker" id="listStatus" name="listStatus" required="">
                        <option value="1">Activo</option>
                        <option value="2">Inactivo</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group photo_url">
                      <label class="control-label">Portada: Pega la URL de la imágen <span class="required">*</span></label>
                      <input class="form-control" id="urlImage" name="urlImage" type="url" required="">
                      <img id="img" src="<?=media()?>/images/uploads/upload.png">
                    </div>
                </div>
                <!--<div class="col-md-6">
                    <div class="photo">
                        <label for="foto">Foto (570x380)</label>
                        <div class="prevPhoto">
                        <span class="delPhoto notBlock">X</span>
                        <label for="foto"></label>
                        <div>
                            <img id="img" src="<?= media();?>/images/uploads/upload.png">
                        </div>
                        </div>
                        <div class="upimg">
                        <input type="file" name="foto" id="foto">
                        </div>
                        <div id="form_alert"></div>
                    </div>
                </div>-->
              </div>
              <hr>
              <div class="tile-footer">
                <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
              </div>
            </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalViewCategoria" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos de Categoria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <td>ID:</td>
                <td id="celId">6565656565</td>
              </tr>
              <tr>
                <td>Nombre:</td>
                <td id="celNombre">6565656565</td>
              </tr>
              <tr>
                <td>Descripcion:</td>
                <td id="celDescripcion">Jacob</td>
              </tr>
              <tr>
                <td>Estado:</td>
                <td id="celEstado">Jacob</td>
              </tr>
              <tr>
                <td>Foto:</td>
                <td id="imgCategoria"></td>
              </tr>
            </tbody>
          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>