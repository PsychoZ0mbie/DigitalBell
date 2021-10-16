<?php
    
    headerPage($data);
    $arrTopics = $data['topics'];
    $arrPost = $data['post'];
    $arrRandom = $data['random'];
    $arrComentarios = $data['comentarios'];
    $registros=$data['registros'];
    $urlShared = base_url()."/publicaciones/articulo/".$arrPost['idpost']."/".urlencode($arrPost['route']);
    require_once("Views/Template/Modals/modalCompartir.php");
    
    
    //getModal('modalCompartir',$data);
?>
    
    <main class="m-t-100 m-b-50 container">
        <div class="row">
            <div class="col-md-7 mt-4">
                <div class="tag-article text-white mb-4">
                    <a class="text-decoration-none text-white"href="<?=base_url().'/publicaciones/categoria/'.$arrPost['idtopic'].'/'.$route;?>"><h4 class="fs-15 text-center"><?=$arrPost['categoria']?></h4></a>
                </div>
                <h1><?=$arrPost['title']?></h1>
                <div class="portada mt-4">
                    <img src="<?=$arrPost['image']?>" alt="<?=$arrPost['title']?>">
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mt-4"><strong>Por<?=' '.$arrPost['autor']?></strong></p>
                        <p class="mt-2"><?=$arrPost['date']?></p>
                        <p><i class="fas fa-comments"></i> (<?=$registros?>) </p>
                    </div>
                    <button class ="share" type="button" onclick="openModal();" ><i class="fas fa-share"></i></button>
                </div>
                <div class="mt-4 img_articulo"><?=$arrPost['description']?></div>
            </div>
            <aside class="col-md-5 mt-4">
                <div class="category">
                    <h3><a href="<?=base_url();?>/publicaciones/categorias">Categorias</a></h3>
                    <ul class="mt-3 fs-20 text-white">
                        <?php
                            for ($i=0; $i < count($arrTopics); $i++) { 
                                $route = $arrTopics[$i]['route'];
                        ?>
                        <li class="list-item">
                            <a href="<?=base_url().'/publicaciones/categoria/'.$arrTopics[$i]['idtopic'].'/'.$route;?>"><?=$arrTopics[$i]['name']?></a>
                            <span>(<?=' '.$arrTopics[$i]['registros'].' '?>)</span>
                        </li>
                        <?php }?>
                    </ul>
                </div>
                <div class="popular-post p-t-50">
                    <h3>Te puede interesar...</h3>
                    <?php
                        for ($i=0; $i < count($arrRandom); $i++) { 
                            $route = urlencode($arrRandom[$i]['route']);
                            $image = $arrRandom[$i]['image'];
                    ?>
                    <div class="position-relative shadow-sm p-3 mb-5 bg-white rounded container m-b-50">
                        <div class="blog-image">
                        <a href="<?=base_url().'/publicaciones/articulo/'.$arrRandom[$i]['idpost'].'/'.$route;?>"><img src="<?=$image?>" alt="<?=$arrRandom[$i]['title']?>" class="img-fluid img-effect"></a>
                        </div>
                        
                        <!--<div class="post-info text-dark fs-12 d-flex justify-content-center">
                            <span><i class="fa fa-user"></i>&nbsp;&nbsp;<?=$arrRandom[$i]['first_name']?></span>
                            <span><i class="fa fa-calendar"></i>&nbsp;&nbsp;<?=$arrRandom[$i]['date']?></span>
                        </div>-->
                        <div class="m-t-20">
                            <a href="<?=base_url().'/publicaciones/articulo/'.$arrRandom[$i]['idpost'].'/'.$route;?>" class="fs-20 text-dark"><strong><?=$arrRandom[$i]['title']?></strong></a>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div>
                    <h3 class="pb-4 pt-4">Siguenos en:</h3>
                    <a href="https://www.facebook.com/digitalbelll/" target=_blank><i class="fs-35 fab fa-facebook-square" aria-hidden="true"></i></a>
                </div>
            </aside>
        </div>
    </main>
    <section class="container">
        <div>
            <hr>
            <h3 class="text-info">(<?=$registros?>) Comentarios</h3>
            <hr>
        </div>
        <div class="tile mt-4 mb-4">
            <br>
            <div class="tile-body">
              <form class="form-horizontal" name="formComentario" id="formComentario">
                <input type="hidden" id="idPost" name="idPost" value="<?=$arrPost['idpost']?>">
                <input type="hidden" id="idComentario" name="idComentario" value="">
                  <div class="ml-5 mr-5">
                    <textarea class="form-control" rows="4" name="txtComentario" id="txtComentario" placeholder="Escribe tu comentario..." required ></textarea>
                  </div>
                  <?php
                        if(isset($_SESSION['login'])){
                    ?>
                    <div class="mt-3 mb-5 ml-5 mr-5">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Publicar</button>
                    </div>
                    <?php }else{ ?>
                    <div class="mt-3 mb-5 ml-5 mr-5">
                        <button class="btn btn-primary btn-comment" type ="button">Publicar</button>
                    </div>
                    <?php }?>
              </form>
            </div>
        </div>
        <!-- Comentarios-->
        <div class="container">
            <?php 
                for ($i=0; $i < count($arrComentarios); $i++) { 
            ?>
            <div class="comment ml-5 mr-5 mb-5">
                <?php 
                    if($arrComentarios[$i]['idrol'] == 1){
                ?>
                <p class="ml-2 mt-2 text-info"><strong>Admin</strong></p>  
                
                <?php }elseif($arrComentarios[$i]['person_id'] == $arrPost['person_id']){
                ?>
                <p class="ml-2 mt-2 text-success"><strong>Autor</strong></p> 
                <?php }?>
                <div class="comment_info ml-4 mr-4 mt-4">
                    <p><?=$arrComentarios[$i]['first_name'].' '.$arrComentarios[$i]['last_name'] ?></p>
                    <p><?=$arrComentarios[$i]['date']?></p>
                </div>
                <hr>
                <p class="ml-4 mr-4 mt-4 mb-4">
                    <?=$arrComentarios[$i]['comment']?>
                </p>
                <hr>
                <div class="ml-4 mt-1 d-flex">
                    <?php
                        if($_SESSION['idUser'] == $arrComentarios[$i]['person_id']){
                    ?>
                    <a href="#formComentario" class="text-info mr-2" onclick="fntEditInfo('<?=$arrComentarios[$i]['idcomment'];?>')">Editar</a>
                    <?php }?>
                    
                    <?php 
                        if($_SESSION['idUser'] == $arrComentarios[$i]['person_id'] || $_SESSION['userData']['idrol']==1 || $_SESSION['userData']['idrol']==2){
                    ?>
                    <button class="text-info" onclick="fntDeleteInfo('<?=$arrComentarios[$i]['idcomment'];?>')">Eliminar</button>
                    <?php }?>
                </div>
            </div>
            <?php }?>
        </div>
    </section>
    
<?php
    footerPage($data);
?>