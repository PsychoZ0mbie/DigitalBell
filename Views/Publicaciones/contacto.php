<?php
    headerPage($data);
?>
    
    <main class="m-t-100 m-b-50 container">
        <form id="frmContacto" class="mt-4">
            <div class="row">
                <div class="col-md-6 contacto">
                    <h2>Contacto</h1>
                    <hr>
                    <br>
                    <div class="form-group">
                        <label for="txtNombreContacto">Nombre</label>
                        <input type="txt" class="form-control" id="txtNombreContacto" name="txtNombreContacto" placeholder="John Doe">
                        <br>
                        <label for="txtEmailContacto">Email</label>
                        <input type="email" class="form-control" id="txtEmailContacto" name="txtEmailContacto" placeholder="name@example.com">
                    </div>
                    <div class="form-group">
                        <label for="txtComentarios">Mensaje</label>
                        <textarea class="form-control" id="txtComentarios" name="txtComentarios" rows="5"></textarea>
                    </div>
                    <button class="form-btn m-0">Enviar</button>
                </div>
                <div class="col-md-6">
                    <div class="m-1">
                        <h3 class="mt-5"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp;Dirección</h2>
                        <br>
                        <p>Condominio Campestre Caracolí</p>
                        <p>Colombia</p>
                    </div>
                    <div class="m-1">
                        <h3 class="mt-5"><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;&nbsp;Email</h2>
                        <br>
                        <p><?=EMAIL_CONTACTO?></p>
                    </div>
                </div>
            </div>
            
        </form>
    </main>
    
<?php
    footerPage($data);
?>