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