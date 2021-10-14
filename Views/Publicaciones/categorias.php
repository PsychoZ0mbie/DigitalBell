<?php
    headerPage($data);
    $arrTopics = $data['topics'];
?>

    <main class="m-t-100 m-b-50 container container-categoria">
        <?php
        for ($i=0; $i < count($arrTopics); $i++) { 
            $route = $arrTopics[$i]['route'];
            $image = $arrTopics[$i]['image'];
        ?>
        <div class="categorias shadow-sm bg-white rounded ">
            <div class="blog-image ">
                <a href="<?=base_url().'/publicaciones/categoria/'.$arrTopics[$i]['idtopic'].'/'.$route;?>"><img src="<?=$image?>" alt="<?=$arrTopics[$i]['name']?>" class="img-effect"></a>
                <div class="post-tag text-white">
                    <h4 class="fs-15 text-center"><a href="<?=base_url().'/publicaciones/categoria/'.$arrTopics[$i]['idtopic'].'/'.$route;?>"><?=$arrTopics[$i]['name']?></a></h4>
                </div>
            </div>
        </div>
        <?php }?>
    </main>
    
<?php
    footerPage($data);
?>