<div class="container-fluid bg-page">
<!--destaque ------------------------------------------------>
<?php if(empty($_GET['pg3']) || $_GET['pg3'] == "filtro"){ ?>
    <?php
    //sql com os destaques do blog
    $query = " SELECT * FROM blog WHERE ativo = 1 AND destaque = 1 AND data <= now() ORDER BY data DESC, id DESC LIMIT 3 ";
    $sql = mysql_query($query);
    $sql2 = mysql_query($query);
    
    //valida se tem destaques ativos
    $validaDestaque = mysql_num_rows($sql);
    if($validaDestaque){
    ?>
    <div class="container">
        <div class="row">
            <?php
            while($array = mysql_fetch_assoc($sql)){
                
                //valida se tem imagem capa
                $imgThumb = "admin/image/blog/{$array['id']}/{$array['id']}thumb.jpg";
                if(file_exists($imgThumb)){
            ?>
            <div class="hidden-xs col-sm-4 col-md-4 col-lg-4">
                <a href="<?php echo "blog/1/{$array['id']}/{$array['slugify']}"; ?>" class="a-block">
                    <div class="box-destaque">
                        <img src="<?php echo $imgThumb; ?>" class="img-responsive auto" alt="<?php echo $array['nome']; ?>" />
                        <div class="titulo-flutuante">
                            <div class="table-cell">
                                <?php echo $array['nome']; ?>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <?php
                }
            }
            ?>
            <div class="col-xs-12 hidden-sm hidden-md hidden-lg">
                <div id="slideshow0" class="owl-carousel" style="padding: 0px; margin: 0px; background: transparent; margin-top: 10px; border: 0px; box-shadow: none;">
                    <?php
                    while($array = mysql_fetch_assoc($sql2)){

                        //valida se tem imagem capa
                        $imgThumb = "admin/image/blog/{$array['id']}/{$array['id']}thumb.jpg";
                        if(file_exists($imgThumb)){
                    ?>
                    <div class="item">
                        <a href="<?php echo "blog/1/{$array['id']}/{$array['slugify']}"; ?>" class="a-block">
                            <div class="box-destaque">
                                <img src="<?php echo $imgThumb; ?>" class="img-responsive auto" alt="<?php echo $array['nome']; ?>" />
                                <div class="titulo-flutuante">
                                    <div class="table-cell">
                                        <?php echo $array['nome']; ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
<?php } ?>
<!--fim destaque --------------------------------------------->

    <!--container do conteudo principal-->
    <div class="container box-page">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <?php
                if($_GET['pg3'] == "perfil"){
                    
                    require_once 'perfil.php';
                    
                }elseif(is_numeric($_GET['pg3']) && is_string($_GET['pg4']) && !empty($_GET['pg4'])){ //valida detalhe noticias
                    
                    require_once 'blog_detalhe.php';
                    
                }else{ //todas as postagens
                ?>
                <div class="col-xs-12 hidden-sm hidden-md hidden-lg">
                        <div class="box-redesociais borders">
                            <?php 
                            $sqlSocial = mysql_query(" SELECT * FROM rede_social WHERE ativo = 1 ORDER BY ordem ASC ");
                            $i=1;
                            while($social = mysql_fetch_assoc($sqlSocial)){
                                ?>
                                <style>
                                    .iconSocial<?php echo $social['id']; ?>{
                                        color: #<?php echo $social['cor']; ?> !important;
                                    }
                                    .iconSocial<?php echo $social['id']; ?>:hover{
                                        color: #<?php echo $social['cor_hover']; ?> !important;
                                    }
                                </style>
                                <?php if($social['link_onclick']){ ?>
                                <a href="http://<?php echo $social['link_onclick']; ?>" style="cursor: pointer; text-decoration: none; padding-left: 10px; padding-right: 10px;" target="_blank" class="iconSocial padding-top-icon-5 iconSocial<?php echo $social['id']; ?> box-redes-sociais" style="margin-left: 4px; text-decoration: none !important;">
                                    <i class="<?php echo $social['icone']; ?> size-icon2"></i>
                                </a>
                                <?php }else{ ?>
                                <a title="<?php echo $social['nome']; ?>" style="text-decoration: none; padding-left: 10px; padding-right: 10px;" class="iconSocial iconSocial<?php echo $social['id']; ?> box-redes-sociais" style="margin-left: 4px; text-decoration: none !important;">
                                    <i class="<?php echo $social['icone']; ?> size-icon2"></i>
                                </a>
                                <?php } ?>
                                <?php 
                                $i++;
                            }
                            ?>
                        </div>
                    </div>
                <div class="row">
                    <div class="col-xs-12 hidden-sm hidden-md hidden-lg">
                        <a href="blog/1/perfil">
                            <div class="box-perfil borders">
                                <img src="./admin/image/perfil/perfil.jpg" class="img-responsive auto" />
                                <div class="titulo-flutuante perfil-flutuante">
                                    <div class="table-cell">
                                        <?php echo $configuracao['nome']; ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xs-12 hidden-sm hidden-md hidden-lg">
                        <div class="box-pesquisa borders">
                            <form method="post" action="<?php echo "{$_GET['pg']}/1/filtro"; ?>">
                                <input type="text" name="pesquisa" value="<?php if($_GET['pg3'] == "filtro" && $_GET['pg4']){ echo $_GET['pg4']; } ?>" class="form-control ipt-pesq" placeholder="Pesquisa" onsubmit="" />
                            </form>
                        </div>
                    </div>
                    <?php
                    
                    //filtro da busca
                    if($_GET['pg3'] == "filtro" && $_POST['pesquisa']){
                        
                        echo "<script>location.href='{$configuracao['url_amigavel']}blog/1/filtro/{$_POST['pesquisa']}';</script>";
                        die();
                    }
                    
                    if($_GET['pg3'] == "filtro" && $_GET['pg4']){
                        $busca = addslashes($_GET['pg4']);
                        $where .= " AND UPPER(nome) LIKE UPPER('%{$busca}%') OR UPPER(descricao) LIKE UPPER('%{$busca}%') ";
                    }
                    
                    if($_GET['pg3'] && empty($_GET['pg4'])){
                        
                        $pg3 = addslashes($_GET['pg3']);
                        
                        $where .= " AND id_categoria = {$pg3} ";
                        
                        $sqlCatFilho = mysql_query(" SELECT * FROM blog_categoria WHERE id_sub = {$pg3} ");
                        $i=1;
                        while($buscaCatFilho = mysql_fetch_assoc($sqlCatFilho)){
                        
                            if($buscaCatFilho['id'] && $buscaCatFilho['id_sub'] > 0){
                                $where .= " OR id_categoria = {$buscaCatFilho['id']} ";
                            }
                            $i++;
                        
                        }
                    }
                    
                    //inicia a paginacao
                    $start = 0;
                    $limit = $configuracao['quantidade_posts_pagina'];
                    
                    if (isset($_GET['pg2'])) {
                        $id = $_GET['pg2'];
                        $start = ($id - 1) * $limit;
                    }
                    
                    $sql = mysql_query(" SELECT * FROM blog WHERE ativo = 1 AND data <= now() {$where} ORDER BY data DESC, id DESC LIMIT $start, $limit ");
                    while($arrayPost = mysql_fetch_assoc($sql)){
                    
                        //sql que gera as tags recursiva por post
                        $sqlCp = " SELECT * FROM blog_categoria WHERE id = {$arrayPost['id_categoria']} ";
                    ?>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="box-posts borders">
                            <div class="row">
                                <div class="hidden-xs col-sm-8 col-md-8 col-lg-8 text-left">
                                    <div class="tag-categoria">
                                    <?php 
                                    $sqlCatPost = mysql_query($sqlCp);
                                    while($catPost = mysql_fetch_assoc($sqlCatPost)){
                                        
                                        if($catPost['id_sub'] > 0){
                                            
                                            $sqlCatPai = busca_array_sql("blog_categoria", "id", $catPost['id_sub']);
                                            echo "<a href='{$configuracao['url_global']}blog/1/{$sqlCatPai['id']}'>{$sqlCatPai['nome']} </a> <i class='fa fa-chevron-right' style='font-size: 11px;'></i> <a href='{$configuracao['url_global']}blog/1/{$catPost['id']}'> {$catPost['nome']} </a>";
                                        }else{
                                            
                                            echo "<a href='{$configuracao['url_global']}blog/1/{$catPost['id']}'> {$catPost['nome']} </a>";
                                        }
                                    }
                                    ?>
                                    </div>
                                </div>
                                <div class="hidden-xs col-sm-4 col-md-4 col-lg-4 text-right">
                                    <div class="data-post">
                                        <?php 
                                        $data = explode("-", $arrayPost['data']);
                                        $dia = $data[2];
                                        $mes = $data[1];
                                        $ano = $data[0];
                                        
                                        $meses = array(" ","Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
                                        
                                        if($mes < 10){
                                            $mes = str_replace("0", "", $mes);
                                        }
                                        
                                        $mesExtenso = $meses[$mes];
                                        
                                        echo $dataFormatada = $dia." de ".$mesExtenso." de ".$ano;
                                        ?>
                                    </div>
                                </div>
                                <div class="col-xs-12 hidden-sm hidden-md hidden-lg text-center">
                                    <div class="tag-categoria-xs">
                                    <?php 
                                    $sqlCatPost = mysql_query($sqlCp);
                                    while($catPost = mysql_fetch_assoc($sqlCatPost)){
                                        if($catPost['id_sub'] > 0){
                                            
                                            $sqlCatPai = busca_array_sql("blog_categoria", "id", $catPost['id_sub']);
                                            echo "<a href='{$configuracao['url_global']}blog/1/{$sqlCatPai['id']}'>{$sqlCatPai['nome']} </a> <i class='fa fa-chevron-right' style='font-size: 11px;'></i> <a href='{$configuracao['url_global']}blog/1/{$catPost['id']}'> {$catPost['nome']} </a>";
                                        }else{
                                            
                                            echo "<a href='{$configuracao['url_global']}blog/1/{$catPost['id']}'> {$catPost['nome']} </a>";
                                        }
                                    }
                                    ?>
                                    </div>
                                </div>
                                <div class="col-xs-12 hidden-sm hidden-md hidden-lg text-center">
                                    <div class="data-post-xs">
                                        <?php 
                                        $data = explode("-", $arrayPost['data']);
                                        $dia = $data[2];
                                        $mes = $data[1];
                                        $ano = $data[0];
                                        
                                        $meses = array(" ","Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
                                        
                                        if($mes < 10){
                                            $mes = str_replace("0", "", $mes);
                                        }
                                        
                                        $mesExtenso = $meses[$mes];
                                        
                                        echo $dataFormatada = $dia." de ".$mesExtenso." de ".$ano;
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!--post-->
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                                    <div class="post">
                                            <h2>
                                                <a href="<?php echo "blog/1/{$arrayPost['id']}/{$arrayPost['slugify']}"; ?>" style="text-decoration: none; color: <?php echo $arrayPost['cor_titulo'] ?>">
                                                    <?php echo $arrayPost['nome']; ?>
                                                </a>
                                            </h2>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="post <?php if ($arrayPost['leia_mais'] == 1){ echo 'box-post-limit'; }else{ echo 'box-post-limit-leia-mais'; } ?>">
                                    <?php echo $arrayPost['descricao']; ?>
                                    </div>
                                </div>
                            </div>
                            <div class='degrade-post'></div>
                            <!--leia mais-->
                            <?php if($arrayPost['leia_mais'] == 1){ ?>
                            <div class="row">
                                <div class="hidden-xs col-sm-12 col-md-12 col-lg-12">
                                    <div class="box-line-leia-mais">
                                        <div class="full-line"></div>
                                        <a class="a-leia-mais" href="<?php echo "blog/1/{$arrayPost['id']}/{$arrayPost['slugify']}"; ?>">LEIA MAIS</a>
                                    </div>
                                </div>
                                <div class="col-xs-12 hidden-sm hidden-md hidden-lg">
                                    <div class="box-line-leia-mais" style="margin-bottom: 18px;">
                                        <div class="full-line" style="width: 90%;"></div>
                                        <a class="a-leia-mais" href="<?php echo "blog/1/{$arrayPost['id']}/{$arrayPost['slugify']}"; ?>">LEIA MAIS</a>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <!--tags e compartilhamento-->
                            <div class="row">
                                <div class="hidden-xs col-sm-6 col-md-6 col-lg-6 text-left">
                                    <?php if($arrayPost['tags']){ ?>
                                    <div class="box-tags-compartilhar">
                                        <i class="fa fa-tag"></i> Tags:
                                        <?php
                                        $tags = explode(",", $arrayPost['tags']);
                                        $contTags = count($tags);
                                        $i=1;
                                        foreach ($tags as $tag) {
                                            echo "<a href='blog/1/filtro/{$tag}' class='tag-filtro'>{$tag}</a>";
                                            if($i < $contTags){ echo ", "; }
                                            $i++;
                                        }
                                        ?>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="hidden-xs col-sm-6 col-md-6 col-lg-6 text-right">
                                    <div class="hidden-xs col-sm-12 col-md-12 col-lg-12 text-right">
                                        <div class="box-tags-compartilhar">
                                            <?php if($arrayPost['facebook_compartilhar'] == 1){ ?>
                                            <div class="">
                                                <i class="fa fa-share-alt"></i> Compartilhe: 
                                                <?php if($arrayPost['facebook_compartilhar'] == 1){ ?>
                                                <a href="<?php echo "http://facebook.com/sharer.php?u={$configuracao['url_global']}facebook/facebook.php?id={$arrayPost['id']}"; ?>" class="a-compartilhe-post" target="_blank"><i class="fa fa-facebook"></i></a>
                                                <?php } ?>

                                                <?php if($arrayPost['twitter_compartilhar'] == 1){ ?>
                                                <a href="<?php echo "http://twitter.com/home?status={$configuracao['url_global']}blog/1/{$arrayPost['id']}/{$arrayPost['slugify']}"; ?>" class="a-compartilhe-post" target="_blank"><i class="fa fa-twitter"></i></a>
                                                <?php } ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="hidden-xs col-sm-12 col-md-12 col-lg-12 text-right">
                                        <?php if($arrayPost['comentario'] == 1){ ?>
                                            <div class="box-tags-compartilhar">
                                                <?php 
                                                $sql3 = mysql_query(" SELECT * FROM comentario WHERE id_post = {$arrayPost['id']} AND ativo = 1 ORDER BY data ASC ");
                                                $countComment = mysql_num_rows($sql3);
                                                ?>
                                                <a class="" href="<?php echo "blog/1/{$arrayPost['id']}/{$arrayPost['slugify']}/#comentario"; ?>">
                                                    <span style="color: #333;">
                                                        <?php if($countComment > 0){ ?>
                                                            <?php echo $countComment; ?> Comentário<?php if($countComment > 1){ echo 's'; } ?> 
                                                        <?php }else{ ?>
                                                            Seja o primeiro a comentar!
                                                        <?php } ?>
                                                    </span>
                                                </a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                
                                <!--XS---------------------->
                                <div class="col-xs-12 hidden-sm hidden-md hidden-lg text-center">
                                    <?php if($arrayPost['tags']){ ?>
                                    <div class="box-tags-compartilhar">
                                        <i class="fa fa-tag"></i> Tags:
                                        <?php
                                        $tags = explode(",", $arrayPost['tags']);
                                        $contTags = count($tags);
                                        $i=1;
                                        foreach ($tags as $tag) {
                                            echo "<a href='blog/1/filtro/{$tag}' class='tag-filtro'>{$tag}</a>";
                                            if($i < $contTags){ echo ", "; }
                                            $i++;
                                        }
                                        ?>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="col-xs-12 hidden-sm hidden-md hidden-lg text-center">
                                    <?php if($arrayPost['facebook_compartilhar'] == 1){ ?>
                                    <div class="box-tags-compartilhar">
                                        <i class="fa fa-share-alt"></i> Compartilhe: 
                                        <?php if($arrayPost['facebook_compartilhar'] == 1){ ?>
                                        <a href="<?php echo "http://facebook.com/sharer.php?u={$configuracao['url_global']}facebook/facebook.php?id={$arrayPost['id']}"; ?>" class="a-compartilhe-post" target="_blank"><i class="fa fa-facebook"></i></a>
                                        <?php } ?>

                                        <?php if($arrayPost['twitter_compartilhar'] == 1){ ?>
                                        <a href="<?php echo "twitter.com/home?status={$configuracao['url_global']}blog/1/{$arrayPost['id']}/{$arrayPost['slugify']}"; ?>" class="a-compartilhe-post" target="_blank"><i class="fa fa-twitter"></i></a>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="col-xs-12 hidden-sm hidden-md hidden-lg text-center">
                                    <?php if($arrayPost['comentario'] == 1){ ?>
                                        <div class="box-tags-compartilhar">
                                            <?php 
                                            $sql3 = mysql_query(" SELECT * FROM comentario WHERE id_post = {$arrayPost['id']} AND ativo = 1 ORDER BY data ASC ");
                                            $countComment = mysql_num_rows($sql3);
                                            ?>
                                            <a class="" href="<?php echo "blog/1/{$arrayPost['id']}/{$arrayPost['slugify']}/#comentario"; ?>">
                                                <span style="color: #333;">
                                                    <?php if($countComment > 0){ ?>
                                                        <?php echo $countComment; ?> Comentário<?php if($countComment > 1){ echo 's'; } ?> 
                                                    <?php }else{ ?>
                                                        Seja o primeiro a comentar!
                                                    <?php } ?>
                                                </span>
                                            </a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
                <?php
                $rows = mysql_num_rows(mysql_query(" SELECT * FROM blog WHERE ativo = 1 {$where} "));
                $total = ceil($rows / $limit);
                if($total > 1){
                    $prev = ($id - 1);
                    $atual = $_GET['pg2'];
                    $next = ($id + 1);
                ?>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        <a href='<?php if($prev >= 1){ echo "blog/{$prev}"; } ?>' class='btn btn-voltar pull-left <?php if($prev < 1){ echo "disabled"; } ?>'>ANTERIOR</a>
                        <div class="btn btn-pag-atual"><?php echo $atual." de ".$total; ?></div>
                        <a href='<?php if($_GET['pg2'] != $total){ echo "blog/{$next}"; } ?>' class='btn btn-voltar pull-right <?php if($_GET['pg2'] == $total){ echo "disabled"; } ?>'>PRÓXIMO</a>
                    </div>
                </div>
                <?php } ?>    
                <?php
                }//fim todas as postagens
                ?>
            </div>
            <div class="hidden-xs col-sm-4 col-md-4 col-lg-4">
                <div class="row">
                    <?php
                    $sqlBanner = mysql_query(" SELECT * FROM banner WHERE ativo = 1 AND id_local = 1 ORDER BY ordem ASC ");
                    $contBanner = mysql_num_rows($sqlBanner);
                    if($contBanner > 0){
                        while($banner = mysql_fetch_assoc($sqlBanner)){
                            $imgBan = "admin/image/banner/{$banner['id']}lg.jpg";
                    ?>
                    <div class="hidden-xs col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 24px;">
                        <?php if($banner['link']){ ?>
                        <a href="http://<?php echo $banner['link']; ?>" target="_blank">
                            <img src="<?php echo $imgBan; ?>" class="img-responsive auto" />
                        </a>
                        <?php }else{ ?>
                        <img src="<?php echo $imgBan; ?>" class="img-responsive auto" />
                        <?php } ?>
                    </div>
                    <?php
                        }
                    }
                    ?>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="box-redesociais borders">
                            <?php 
                            $sqlSocial = mysql_query(" SELECT * FROM rede_social WHERE ativo = 1 ORDER BY ordem ASC ");
                            $i=1;
                            while($social = mysql_fetch_assoc($sqlSocial)){
                                ?>
                                <style>
                                    .iconSocial<?php echo $social['id']; ?>{
                                        color: #<?php echo $social['cor']; ?> !important;
                                    }
                                    .iconSocial<?php echo $social['id']; ?>:hover{
                                        color: #<?php echo $social['cor_hover']; ?> !important;
                                    }
                                </style>
                                <?php if($social['link_onclick']){ ?>
                                <a href="http://<?php echo $social['link_onclick']; ?>" style="cursor: pointer; text-decoration: none; padding-left: 10px; padding-right: 10px;" target="_blank" class="iconSocial padding-top-icon-5 iconSocial<?php echo $social['id']; ?> box-redes-sociais" style="margin-left: 4px; text-decoration: none !important;">
                                    <i class="<?php echo $social['icone']; ?> size-icon2"></i>
                                </a>
                                <?php }else{ ?>
                                <a title="<?php echo $social['nome']; ?>" style="text-decoration: none; padding-left: 10px; padding-right: 10px;" class="iconSocial iconSocial<?php echo $social['id']; ?> box-redes-sociais" style="margin-left: 4px; text-decoration: none !important;">
                                    <i class="<?php echo $social['icone']; ?> size-icon2"></i>
                                </a>
                                <?php } ?>
                                <?php 
                                $i++;
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                    $sqlBanner = mysql_query(" SELECT * FROM banner WHERE ativo = 1 AND id_local = 2 ORDER BY ordem ASC ");
                    $contBanner = mysql_num_rows($sqlBanner);
                    if($contBanner > 0){
                        while($banner = mysql_fetch_assoc($sqlBanner)){
                            $imgBan = "admin/image/banner/{$banner['id']}lg.jpg";
                    ?>
                    <div class="hidden-xs col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 24px;">
                        <?php if($banner['link']){ ?>
                        <a href="http://<?php echo $banner['link']; ?>" target="_blank">
                            <img src="<?php echo $imgBan; ?>" class="img-responsive auto" />
                        </a>
                        <?php }else{ ?>
                        <img src="<?php echo $imgBan; ?>" class="img-responsive auto" />
                        <?php } ?>
                    </div>
                    <?php
                        }
                    }
                    ?>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <a href="blog/1/perfil">
                            <div class="box-perfil borders">
                                <img src="./admin/image/perfil/perfil.jpg" class="img-responsive auto" />
                                <div class="titulo-flutuante perfil-flutuante">
                                    <div class="table-cell">
                                        <?php echo $configuracao['nome']; ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                    $sqlBanner = mysql_query(" SELECT * FROM banner WHERE ativo = 1 AND id_local = 3 ORDER BY ordem ASC ");
                    $contBanner = mysql_num_rows($sqlBanner);
                    if($contBanner > 0){
                        while($banner = mysql_fetch_assoc($sqlBanner)){
                            $imgBan = "admin/image/banner/{$banner['id']}lg.jpg";
                    ?>
                    <div class="hidden-xs col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 24px;">
                        <?php if($banner['link']){ ?>
                        <a href="http://<?php echo $banner['link']; ?>" target="_blank">
                            <img src="<?php echo $imgBan; ?>" class="img-responsive auto" />
                        </a>
                        <?php }else{ ?>
                        <img src="<?php echo $imgBan; ?>" class="img-responsive auto" />
                        <?php } ?>
                    </div>
                    <?php
                        }
                    }
                    ?>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="box-pesquisa borders">
                            <form method="post" action="<?php echo "{$_GET['pg']}/1/filtro"; ?>">
                                <input type="text" name="pesquisa" value="<?php if($_GET['pg3'] == "filtro" && $_GET['pg4']){ echo $_GET['pg4']; } ?>" class="form-control ipt-pesq" placeholder="Pesquisa" onsubmit="" />
                            </form>
                        </div>
                    </div>
                    <?php
                    $sqlBanner = mysql_query(" SELECT * FROM banner WHERE ativo = 1 AND id_local = 4 ORDER BY ordem ASC ");
                    $contBanner = mysql_num_rows($sqlBanner);
                    if($contBanner > 0){
                        while($banner = mysql_fetch_assoc($sqlBanner)){
                            $imgBan = "admin/image/banner/{$banner['id']}lg.jpg";
                    ?>
                    <div class="hidden-xs col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 24px;">
                        <?php if($banner['link']){ ?>
                        <a href="http://<?php echo $banner['link']; ?>" target="_blank">
                            <img src="<?php echo $imgBan; ?>" class="img-responsive auto" />
                        </a>
                        <?php }else{ ?>
                        <img src="<?php echo $imgBan; ?>" class="img-responsive auto" />
                        <?php } ?>
                    </div>
                    <?php
                        }
                    }
                    ?>
                    <?php if($configuracao['instagram_frame'] && $configuracao['instagram_nome']){ //valida se tem insta configurado ?>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="box-instagram borders">
                            <div class="insta-ultimas">ÚLTIMAS DO INSTAGRAM</div>
                            <?php echo $configuracao['instagram_frame']; ?>
                            <div class="insta-nome"><?php echo $configuracao['instagram_nome']; ?></div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php
                    $sqlBanner = mysql_query(" SELECT * FROM banner WHERE ativo = 1 AND id_local = 5 ORDER BY ordem ASC ");
                    $contBanner = mysql_num_rows($sqlBanner);
                    if($contBanner > 0){
                        while($banner = mysql_fetch_assoc($sqlBanner)){
                            $imgBan = "admin/image/banner/{$banner['id']}lg.jpg";
                    ?>
                    <div class="hidden-xs col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 24px;">
                        <?php if($banner['link']){ ?>
                        <a href="http://<?php echo $banner['link']; ?>" target="_blank">
                            <img src="<?php echo $imgBan; ?>" class="img-responsive auto" />
                        </a>
                        <?php }else{ ?>
                        <img src="<?php echo $imgBan; ?>" class="img-responsive auto" />
                        <?php } ?>
                    </div>
                    <?php
                        }
                    }
                    ?>
                    <?php if($configuracao['facebook_frame'] && $configuracao['facebook_frame']){ //valida se tem insta configurado ?>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="box-instagram borders">
                            <div class="insta-ultimas">FACEBOOK</div>
                            <?php echo $configuracao['facebook_frame']; ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php
                    $sqlBanner = mysql_query(" SELECT * FROM banner WHERE ativo = 1 AND id_local = 6 ORDER BY ordem ASC ");
                    $contBanner = mysql_num_rows($sqlBanner);
                    if($contBanner > 0){
                        while($banner = mysql_fetch_assoc($sqlBanner)){
                            $imgBan = "admin/image/banner/{$banner['id']}lg.jpg";
                    ?>
                    <div class="hidden-xs col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 24px;">
                        <?php if($banner['link']){ ?>
                        <a href="http://<?php echo $banner['link']; ?>" target="_blank">
                            <img src="<?php echo $imgBan; ?>" class="img-responsive auto" />
                        </a>
                        <?php }else{ ?>
                        <img src="<?php echo $imgBan; ?>" class="img-responsive auto" />
                        <?php } ?>
                    </div>
                    <?php
                        }
                    }
                    ?>
                    <?php
                    $sqlMaisLidas = " SELECT * FROM blog WHERE ativo = 1 AND data <= now() AND data BETWEEN DATE_SUB(NOW(), INTERVAL {$configuracao['tempo_posts']} DAY) AND NOW() ORDER BY view DESC, data DESC LIMIT {$configuracao['quantidade_posts']}";
                    $validaMaisLidas = mysql_num_rows(mysql_query($sqlMaisLidas));
                    if($validaMaisLidas > 0){
                    ?>
                    <div class="hidden-xs hidden-sm hidden-md col-lg-12">
                        <div class="box-maislidas borders">
                            <div class="insta-ultimas">MAIS LIDAS</div>
                            <ul class="ul-maislidas">
                                <?php
                                $sqlLG = mysql_query($sqlMaisLidas);
                                while($maisLidas = mysql_fetch_assoc($sqlLG)){  
                                    
                                    $img = "./admin/image/blog/{$maisLidas['id']}/{$maisLidas['id']}thumbxs.jpg";  
                                ?>
                                <li>
                                    <a href="<?php echo "blog/1/{$maisLidas['id']}/{$maisLidas['slugify']}"; ?>" class="mais-lidas-a">
                                        <?php if(file_exists($img)){ ?><img src="<?php echo $img; ?>" class="img-responsive" /> <?php } ?>
                                        <div class="titulo-data-maislidas">
                                            <div class="table-cell">
                                                <span class="titulo-maislidas"><?php echo $maisLidas['nome']; ?></span>
                                                <span class="dataMaisLidasSmall"><?php echo dataNormal($maisLidas['data']); ?></span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="hidden-xs col-sm-12 col-md-12 hidden-lg">
                        <div class="box-maislidas borders">
                            <div class="insta-ultimas">MAIS LIDAS</div>
                            <ul class="ul-maislidas">
                                <?php
                                $sqlOther = mysql_query($sqlMaisLidas);
                                while($maisLidas = mysql_fetch_assoc($sqlOther)){
                                    $img = "./admin/image/blog/{$maisLidas['id']}/{$maisLidas['id']}thumbxs.jpg";  
                                ?>
                                <li>
                                    <a href="<?php echo "blog/1/{$maisLidas['id']}/{$maisLidas['slugify']}"; ?>">
                                        <?php if(file_exists($img)){ ?><img src="<?php echo $img; ?>" class="img-responsive" /> <?php } ?>
                                        <div class="titulo-data-maislidas titulo-xs-sm-md">
                                            <div class="table-cell">
                                                <span class="titulo-maislidas"><?php echo $maisLidas['nome']; ?></span>
                                                <span class="dataMaisLidasSmall"><?php echo dataNormal($maisLidas['data']); ?></span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                    <?php
                    $sqlBanner = mysql_query(" SELECT * FROM banner WHERE ativo = 1 AND id_local = 7 ORDER BY ordem ASC ");
                    $contBanner = mysql_num_rows($sqlBanner);
                    if($contBanner > 0){
                        while($banner = mysql_fetch_assoc($sqlBanner)){
                            $imgBan = "admin/image/banner/{$banner['id']}lg.jpg";
                    ?>
                    <div class="hidden-xs col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 24px;">
                        <?php if($banner['link']){ ?>
                        <a href="http://<?php echo $banner['link']; ?>" target="_blank">
                            <img src="<?php echo $imgBan; ?>" class="img-responsive auto" />
                        </a>
                        <?php }else{ ?>
                        <img src="<?php echo $imgBan; ?>" class="img-responsive auto" />
                        <?php } ?>
                    </div>
                    <?php
                        }
                    }
                    ?>
                    <?php if($configuracao['youtube_frame']){ ?>
                    <div class="hidden-xs col-sm-12 col-md-12 col-lg-12">
                        <?php if($configuracao['youtube_nome']){ ?>
                        <div class="box-button-youtube">
                            <?php echo $configuracao['youtube_nome']; ?>
                            <div class="box-button-you pull-right"><?php echo $configuracao['youtube_frame']; ?></div>
                        </div>
                        <?php } ?>
                        <iframe width="100%" height="315" src="<?php echo $configuracao['link_youtube']; ?>" style="border: 0px; background: transparent; margin-bottom: 18px;"></iframe>
                    </div>
                    <?php } ?>
                    <?php
                    $sqlBanner = mysql_query(" SELECT * FROM banner WHERE ativo = 1 AND id_local = 8 ORDER BY ordem ASC ");
                    $contBanner = mysql_num_rows($sqlBanner);
                    if($contBanner > 0){
                        while($banner = mysql_fetch_assoc($sqlBanner)){
                            $imgBan = "admin/image/banner/{$banner['id']}lg.jpg";
                    ?>
                    <div class="hidden-xs col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 24px;">
                        <?php if($banner['link']){ ?>
                        <a href="http://<?php echo $banner['link']; ?>" target="_blank">
                            <img src="<?php echo $imgBan; ?>" class="img-responsive auto" />
                        </a>
                        <?php }else{ ?>
                        <img src="<?php echo $imgBan; ?>" class="img-responsive auto" />
                        <?php } ?>
                    </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>