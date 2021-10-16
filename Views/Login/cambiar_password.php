<?php
    headerPage($data);
?>
<div class="container m-t-50 m-b-50 p-r-200 p-l-200">
  <div class="row">
    <div class="col-md-12">
      <form id="formCambiarPass" name="formCambiarPass" class="forget-form" action="">
          <input type="hidden" id="idUsuario" name="idUsuario" value="<?= $data['id_person'];?>" required>
          <input type="hidden" id="txtEmailRecuperar" name="txtEmailRecuperar" value="<?= $data['email'];?>" required>
          <input type="hidden" id="txtToken" name="txtToken" value="<?= $data['token'];?>" required>
        <h3 class="m-b-20"><strong>Cambiar contraseña</strong></h3>
        <div class="form-group">
          <input id="txtPasswordRecuperar" name="txtPasswordRecuperar" class="form-control mt-4" type="password" placeholder="Nueva contraseña" required>
          <input id="txtPasswordConfirmRecuperar" name="txtPasswordConfirmRecuperar" class="form-control mt-4" type="password" placeholder="Confirmar contraseña" required>  
        </div>
        <div class="form-group btn-container">
          <button type="submit" class="btn btn-primary btn-block mt-4"><i class="fa fa-unlock fa-lg fa-fw"></i> REINICIAR</button>
        </div>
      </form>
    </div>
  </div>
</div>
	
<?php
   footerPage($data);
?>