<!-- Modal -->
<div class="modal fade" id="modalFormArticulos" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Artículo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body ">
            <form id="formArticulo" name="formArticulo" class="form-horizontal" novalidate>
              <input type="hidden" id="idArticulo" name="idArticulo" value="">
              <input type="hidden" id="foto_actual" name="foto_actual" value="">
              <input type="hidden" id="foto_remove" name="foto_remove" value="0">

              <p class="text-primary">Los campos con asterisco (<span class="required">*</span>)son obligatorios.</p>
              <div class="row">
                <div class="col-md-12">
                  <div class="row">
                    <div class="form-group col-md-12">
                      <label class="control-label">Título <span class="required">*</span></label>
                      <input class="form-control" id="txtNombre" name="txtNombre" type="text" required="">
                      <div id="contador"></div>
                    </div>
                  </div>
                  <div class="row">
                        <div class="form-group col-md-6">
                            <label for = "listCategoria">Categoría <span class="required">*</span></label>
                            <select name="listCategoria" id="listCategoria" class="form-control" required="" data-live-search="true"></select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="listStatus">Estado <span class="required">*</span></label>
                            <select class="form-control selectpicker" id="listStatus" name="listStatus" required="">
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label">Descripción <span class="required">*</span></label>
                      <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                      <label class="control-label">Portada del artículo</label>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input methodImage" type="radio" id="checkUrl" name="checkImage" checked value="url">Imágen desde la web
                        </label>
                      </div>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input methodImage" type="radio" id="checkImg" name="checkImage" value="archivo">Imágen desde el equipo
                        </label>
                      </div>
                      <hr>
                      <br>
                      <div class="form-group d-none" id="cargaUrl">
                        <div class="row">
                          <div class="col-md-6">
                            <label class="control-label">Copia y pega la URL de una imágen de internet <span class="required">*</span></label>
                            <ul class="text-danger">
                              <li>La imágen debe ser de calidad</li>
                            </ul>
                            <p class="text-danger">Si no se cumple el requisito, la imágen será eliminada del artículo.</p>
                            <input id="urlImage"  name="urlImage" type="url" required="">
                          </div>
                          <div class="form-group col-md-6 photo_url">
                              <img id="imgUrl" src="<?=media()?>/images/uploads/upload.png">
                          </div>
                        </div>
                      </div>
                      <div class="form-group d-none" id="cargaArchivo">
                        <div class="row">
                          <div class="col-md-6">
                            <label class="control-label">Carga una imágen desde tu computador <span class="required">*</span></label>
                            <ul class="text-danger">
                              <li>La imágen debe ser de calidad</li>
                              <li>La imágen debe ser original, hecha por ti mism@.</li>
                            </ul>
                            <p class="text-danger">Si no se cumplen los requisitos, la imágen será eliminada del artículo.</p>
                            <input type="file" id="fileImage" name="fileImage">
                          </div>
                          <div class="form-group col-md-6 photo_url">
                              <img id="imgFile" src="<?=media()?>/images/uploads/upload.png">
                          </div>
                        </div>
                      </div>
                    </div>         
                    <!--<div class="form-group">
                      <div class="photo">
                          <label for="foto">Portada (570x380)</label>
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
                    <hr>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <button id="btnActionForm" class="btn btn-primary btn-lg btn-block" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>
                        </div>
                        <div class="form-group col-md-6">
                            <button class="btn btn-danger btn-lg btn-block" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
                        </div>
                    </div>
                </div>
              </div>
            </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalViewArticulo" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lx">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del artículo</h5>
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
                <td>Título:</td>
                <td id="celNombre"></td>
              </tr>
              <tr>
                <td>Autor:</td>
                <td id="celAutor"></td>
              </tr>
              <tr>
                <td>Categoría:</td>
                <td id="celCategoria"></td>
              </tr>
              <tr>
                <td>Status:</td>
                <td id="celEstado"></td>
              </tr>
              <tr>
                <td>Fecha:</td>
                <td id="celFecha"></td>
              </tr>
              <tr>
                <td>Foto:</td>
                <td id="imgArticulo"></td>
              </tr>
            </tbody>
          </table>
      </div>
      <div class="modal-footer">
        <a id="link" name="link" class="btn btn-primary" href="" target=_blank>Ver en página</a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>