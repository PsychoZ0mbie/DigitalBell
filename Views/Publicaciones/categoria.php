<?php
    headerPage($data);
    $arrTopics = $data['topics'];
    $arrPost = $data['post'];
    $arrRandom = $data['random'];
?>

    <main class="m-t-100 m-b-50 container blog-categoria ">
        <div class="text-white mb-4">
            <h1 class="fs-25 text-info"><strong><?=$arrTopics?></strong></h1>
        </div>
        <div class="container-categoria">
            <?php
            for ($i=0; $i < count($arrPost); $i++) { 
                $route = urlencode($arrPost[$i]['route']);
                $image = $arrPost[$i]['image'];
            ?>
            <div class="categoria mt-4">
                <div class="blog-image">
                    <a href="<?=base_url().'/publicaciones/articulo/'.$arrPost[$i]['idpost'].'/'.$route;?>"><img src="<?=$image?>" alt="<?=$arrPost[$i]['title']?>" class="img-fluid img-effect"></a>
                </div>
                <div>
                    <h2 class="mt-5 fs-20" style="word-wrap:break-word";><strong><?=$arrPost[$i]['title']?></strong></h2>
                    <button type="button" class="btn btn-post-info pb-2 pt-2 pl-5 pr-5 mt-3 mb-3">
                        <a href="<?=base_url().'/publicaciones/articulo/'.$arrPost[$i]['idpost'].'/'.$route;?>" class="text-white text-center text-white  fs-15">Ver más&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></a>
                    </button>
                </div>
            </div>
            <?php }?>
        </div>
    </main>
    
<?php
    footerPage($data);
?>