<?php
    headerPage($data);
    $arrTopics = $data['topics'];
    $arrPost = $data['post'];
    $arrRandom = $data['random'];
    $banner = $data['banner']
?>
    <!-- Main content-->
    <main class="container m-t-50">
        <section class="row">
            <div class="col-12">
                <div class="banner">
                    <a href="<?=base_url().'/publicaciones/articulo/'.$banner['idpost'].'/'.$banner['route'];?>"><img class="img-fluid" src="<?=$banner['image']?>" alt="<?=$banner['title']?>"></a>
                    <div class="banner-content">
                        <a href="<?=base_url().'/publicaciones/articulo/'.$banner['idpost'].'/'.$banner['route'];?>"><h1 class ="fs-35 mt-2 text-white" style="word-wrap:break-word";><strong><?=$banner['title']?></strong></h1></a>
                        <p class="mt-4 fs-15 text-white"><strong><?='Por '.$banner['first_name'].' '.$banner['last_name']?></strong></p>
                        <a href="<?=base_url().'/publicaciones/categoria/'.$banner['idtopic'].'/'.$banner['route'];?>"><h4 class="mt-4 text-white"><strong><?=$banner['categoria']?></strong></h4></a>
                    </div>
                </div>
                <!--<div class="row mt-4">
                    <?php
                        for ($i=0; $i < 3; $i++) { 
                            $route = urlencode($arrRandom[$i]['route']);
                            $image = $arrRandom[$i]['image'];
                    ?>
                    <div class="col-md-4 blog-image mb-4">
                        <a href="<?=base_url().'/publicaciones/articulo/'.$arrRandom[$i]['idpost'].'/'.$route;?>"><img src="<?=$image?>" alt="<?=$arrRandom[$i]['title']?>"></a>
                        <a class="text-dark" href="<?=base_url().'/publicaciones/articulo/'.$arrRandom[$i]['idpost'].'/'.$route;?>"><h2 class ="fs-20 mt-2" style="word-wrap:break-word";><strong><?=$arrRandom[$i]['title']?></strong></h2></a>
                        <a href="<?=base_url().'/publicaciones/categoria/'.$arrRandom[$i]['idtopic'].'/'.$route;?>"><h4 class="mt-4 text-primary"><?=$arrRandom[$i]['categoria']?></h4></a>
                    </div>
                    <?php } ?>
                </div>-->
            </div>
        </section>
    </main>
    


    <section class="m-t-100 m-b-50 container">
        <div class="row">
            <div class="col-md-7">
                <h2 class="mb-4">Lo más reciente</h2>
                <?php
                for ($i=0; $i < count($arrPost); $i++) { 
                    $route = $arrPost[$i]['route'];
                    $image = $arrPost[$i]['image'];
                ?>
                <div class="position-relative shadow-sm p-3 mb-5 bg-white rounded container m-b-50">
                    <div class="blog-image">
                        <a href="<?=base_url().'/publicaciones/articulo/'.$arrPost[$i]['idpost'].'/'.$route;?>"><img src="<?=$image?>" alt="<?=$arrPost[$i]['title']?>" class="img-fluid img-effect"></a>
                        <div class="post-tag text-white">
                            <a class="text-white" href="<?=base_url().'/publicaciones/categoria/'.$arrPost[$i]['idtopic'].'/'.$route;?>"><h4 class="fs-15 text-center"><?=$arrPost[$i]['categoria']?></h4></a>
                        </div>
                    </div>
                    
                    <!--<div class="post-info text-white fs-13">
                        <span><i class="fa fa-user"></i>&nbsp;&nbsp;<?=$arrPost[$i]['first_name']?></span>
                        <span><i class="fa fa-calendar"></i>&nbsp;&nbsp;<?= $arrPost[$i]['date']?></span>
                    </div>-->
                    <div class="title-h3">
                        <h3 class="mt-5" style="word-wrap:break-word";><strong><?=$arrPost[$i]['title']?></strong></h3>
                        <button type="button" class="btn btn-post-info pb-2 pt-2 pl-5 pr-5 mt-3 mb-3">
                            <a href="<?=base_url().'/publicaciones/articulo/'.$arrPost[$i]['idpost'].'/'.$route;?>" class="text-white text-center text-white  fs-15">Ver más&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></a>
                        </button>
                    </div>
                </div>
                <?php }?>
                <!--<ul class="page d-flex justify-content-center">
                    <li class="m-r-20 page-number "><a href="#" class="previus"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li>
                    <li class="m-r-20 page-number active"><a href="#">1</a></li>
                    <li class="m-r-20 page-number"><a href="#">2</a></li>
                    <li class="m-r-20 page-number"><a href="#">3</a></li>
                    <li class="m-r-20 page-number "><a href="#" class="next"><i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
                </ul>-->
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
                            $route = $arrRandom[$i]['route'];
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
        
    </section>
    
<?php
    footerPage($data);
?>