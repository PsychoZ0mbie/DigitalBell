<?php 
    $cat=getCatFooter();
?>
    <footer class="bg-dark p-t-50">
        <div class="logo-footer d-flex justify-content-center mb-2">
            <a href="<?=base_url();?>"><span class="text-white fs-50 text-center"><?=NOMBRE_EMPRESA?></span></a>
        </div>
        <div class="container footer h-25">
                
                <div class="item_footer">
                    <a href="<?=base_url();?>/publicaciones/categorias"><span class="text-white">Categorías</span></a>
                    <ul class="p-t-30">
                        <?php
                            for ($i=0; $i < count($cat) ; $i++) { 
                                $route = $cat[$i]['route'];
                            
                        ?>
                        <li><a href="<?=base_url().'/publicaciones/categoria/'.$cat[$i]['idtopic'].'/'.$route;?>"><?=$cat[$i]['name']?></a></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="item_footer">
                    <a href="<?=base_url();?>/publicaciones/Mas"><span class="text-white">Más</span></a>
                    <ul class="p-t-30">
                        <!--<li><a href="<?=base_url();?>/Nosotros">Nosotros</a></li>-->
                        <li><a href="<?=base_url();?>/publicaciones/contacto">Contacto</a></li>
                        <li><a href="<?=base_url();?>/publicaciones/Mas" >Política de privacidad</a></li>
                        <li><a href="<?=base_url();?>/publicaciones/Mas">Política de Cookies</a></li>
                    </ul>
                </div>
                <p class="item_footer text-center">Derechos de autor ©2021 David Parrado. Todos los derechos reservados</p>
        </div>
    </footer>
    
    <script>
        const base_url = "<?= base_url(); ?>";
    </script>
    
        <!-- Essential javascripts for application to work-->
    <script src="<?= media(); ?>/js/jquery-3.3.1.min.js?n=1"></script>
    <script src="<?= media(); ?>/js/popper.min.js?n=1"></script>
    <script src="<?= media(); ?>/js/bootstrap.min.js?n=1"></script>
    <!--<script async custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/amp-iframe-0.1.js"></script>-->

    <!-- The javascript plugin to display page loading on top-->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Functions made by me-->
    <script src="<?= media(); ?>/js/functions_admin.js?n=1"></script>
    <script src="<?= media(); ?>/js/functions-blog.js?n=1"></script>
    <script src="<?= media(); ?>/js/functions_login.js?n=1"></script>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org/",
      "@type": "Person",
      "name": "DigitalBell",
      "url": "<?= base_url();?>",
      "logo": "<?= media();?>/images/uploads/icono.png",
      "email": "<?=EMAIL_REMITENTE?>",
      "contactPoint" : [
            {
            "@type" : "ContactPoint",
            "contactType" : "customer service",
            "email": "<?=EMAIL_CONTACTO?>",
            "url": "<?= base_url();?>"
            }
        ]
    }
    </script>
    </body>
</html>