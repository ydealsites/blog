<?php
//valida se tem o id para localizar as informacoes
if ($_GET['pg3']) {

    $pg3 = addslashes($_GET['pg3']);
    $post = busca_array_sql("blog", "id", $pg3);
    
    //atualiza a quantidade de views
    $newViwers = $post['view']+1;
    $update = mysql_query(" UPDATE blog SET view = {$newViwers} WHERE id = {$post['id']} ");
    
    //sql que gera as tags recursiva por post
    $sqlCp = " SELECT * FROM blog_categoria WHERE id = {$post['id_categoria']} ";
}

if($_POST && $_POST['comentario']){
    
    $msg1 = "Seu comentário foi enviado com sucesso.";
    $msg2 = "Os campos obrigatórios devem ser preenchidos.";
    $msg3 = "O captcha deve ser verificado.";
    $msg4 = "O captcha não foi verificado.";
    
    if(empty($_POST['g-recaptcha-response'])){
        
        $_POST['msg3'] = $msg3;
        //redireciona para o envio novamente
        //echo "<script>location.href='{$configuracao['url_global']}{$_GET['pg']}/{$_GET['pg2']}/{$_GET['pg3']}/{$_GET['pg4']}'</script>";
        //die();
        
    }else{
        
        //valida se o captha esta ok
        $secret = "6LeBIxkTAAAAAIGl_AqubkpdJnze0ID3dOzsprLW";
        $captcha = $_POST['g-recaptcha-response'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $rsp = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip=$ip");
        $arr = json_decode($rsp,TRUE);
        
        if($arr['success']){
            //valida se os campos estao preenchidos
            if($_POST['nome'] && $_POST['email'] && $_POST['descricao']){

                //dados gerais necessarios
                $_POST['ativo'] = 0;
                $_POST['data'] = date("Y-m-d");

                //insere na tabela de comentarios
                $return = gerenciaPost("comentario");
                
                //informa por e-mail se você tem um novo comentário

                //inclui a funcao de enviar email
                require_once './send_email/sendEmail.php';
                //Do cliente
                $nome_de = addslashes($_POST['nome']);
                $email_de = addslashes($_POST['email']);
                //para o site
                $nome_para = $configuracao_email['nome'];
                $email_para = $configuracao_email['destinatario'];
                //assunto e mensagem
                $assunto = "Você tem um novo comentário [{$configuracao['nome']}]";
                $mensagem = "Você tem um novo comentário para aprovação.<br/><br/>"
                            . "<strong>Data: </strong> ".date("d/m/Y")." <br/>"
                            . "<strong>Nome: </strong> {$nome_de}<br/>"
                            . "<strong>E-mail: </strong> {$email_de}<br/>"
                            . "<strong>Post: </strong> {$post['nome']}<br/>"
                            . "<strong>Comentário:</strong> ".addslashes($_POST['descricao']);

                //dispara o e-mail
                sendEmail(utf8_decode($nome_de ." (". addslashes($_POST['email']).")"), $email_de, utf8_decode($nome_para), $email_para, utf8_decode($assunto), $mensagem);

                $_POST['msg1'] = $msg1;
                //redireciona para pagina apos o envio


            }else{

                $_POST['msg2'] = $msg2;
                //se der algum erro volta para o formulario
                //echo "<script>location.href='" . $configuracao['url_global'] . "{$_GET['pg']}/{$_GET['pg2']}/{$_GET['pg3']}/{$_GET['pg4']}#info'</script>";
                
            }//if campos preenchidos
            
        }else{
            
            $_POST['msg4'] = $msg4;
            
        }//if captcha OK
        
    }//if captcha valida confirmado
    
}//if comentario

if($_POST && $_POST['contato']){
    
    $msg1 = "Seu contato foi enviado com sucesso.";
    $msg2 = "Os campos obrigatórios devem ser preenchidos.";
    $msg3 = "O captcha deve ser verificado.";
    $msg4 = "O captcha não foi verificado.";
    
    if(empty($_POST['g-recaptcha-response'])){
        
        $_POST['msg3'] = $msg3;
        //redireciona para o envio novamente
        //echo "<script>location.href='{$configuracao['url_global']}{$_GET['pg']}/{$_GET['pg2']}/{$_GET['pg3']}/{$_GET['pg4']}'</script>";
        //die();
        
    }else{
        
        //valida se o captha esta ok
        $secret = "6LeBIxkTAAAAAIGl_AqubkpdJnze0ID3dOzsprLW";
        $captcha = $_POST['g-recaptcha-response'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $rsp = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip=$ip");
        $arr = json_decode($rsp,TRUE);
        
        if($arr['success']){
            //valida se os campos estao preenchidos
            if($_POST['nome'] && $_POST['email'] && $_POST['descricao']){

                //dados gerais necessarios
                $_POST['data'] = date("Y-m-d");
               
                //informa por e-mail se você tem um novo comentário

                //inclui a funcao de enviar email
                require_once './send_email/sendEmail.php';
                //Do cliente
                $nome_de = addslashes($_POST['nome']);
                $email_de = addslashes($_POST['email']);
                //para o site
                $nome_para = $configuracao_email['nome'];
                $email_para = $configuracao_email['destinatario'];
                //assunto e mensagem
                $assunto = "Contato pelo Site [{$configuracao['nome']}]";
                $mensagem = "Você recebeu um novo contato pelo site.<br/><br/>"
                            . "<strong>Data: </strong> ".date("d/m/Y")." <br/>"
                            . "<strong>Nome: </strong> {$nome_de}<br/>"
                            . "<strong>E-mail: </strong> {$email_de}<br/>"
                            . "<strong>Telefone: </strong> {$_POST['fone']}<br/>"
                            . "<strong>Mensagem:</strong> ".addslashes($_POST['descricao']);

                //dispara o e-mail
                sendEmail(utf8_decode($nome_de ." (". addslashes($_POST['email']).")"), $email_de, utf8_decode($nome_para), $email_para, utf8_decode($assunto), $mensagem);

                $_POST['msg1'] = $msg1;
                //redireciona para pagina apos o envio


            }else{

                $_POST['msg2'] = $msg2;
                //se der algum erro volta para o formulario
                
            }//if campos preenchidos
            
        }else{
            
            $_POST['msg4'] = $msg4;
            
        }//if captcha OK
        
    }//if captcha valida confirmado
    
}//if comentario


?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box-posts borders">
            <div class="row">
                <div class="hidden-xs col-sm-8 col-md-8 col-lg-8 text-left">
                    <div class="tag-categoria">
                        <?php
                        $sqlCatPost = mysql_query($sqlCp);
                        while ($catPost = mysql_fetch_assoc($sqlCatPost)) {
                            
                            if($catPost['id_sub'] > 0){
                                            
                                $sqlCatPai = busca_array_sql("blog_categoria", "id", $catPost['id_sub']);
                                echo "<a href='{$configuracao['url_global']}blog/1/{$sqlCatPai['id']}'>{$sqlCatPai['nome']} </a> <i class='fa fa-chevron-right' style='font-size: 11px;'></i> <a href='{$configuracao['url_global']}blog/1/{$catPost['id']}'> {$catPost['nome']} </a> <i class='fa fa-chevron-right' style='font-size: 11px;'></i> {$post['nome']}";
                            }else{

                                echo $catPost['nome'];
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="hidden-xs col-sm-4 col-md-4 col-lg-4 text-right">
                    <div class="data-post">
                        <?php 
                        $data = explode("-", $post['data']);
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
                        while ($catPost = mysql_fetch_assoc($sqlCatPost)) {
                            if($catPost['id_sub'] > 0){
                                            
                                $sqlCatPai = busca_array_sql("blog_categoria", "id", $catPost['id_sub']);
                                echo "<a href='{$configuracao['url_global']}blog/1/{$sqlCatPai['id']}'>{$sqlCatPai['nome']} </a> <i class='fa fa-chevron-right' style='font-size: 11px;'></i> <a href='{$configuracao['url_global']}blog/1/{$catPost['id']}'>{$catPost['nome']} </a> <i class='fa fa-chevron-right' style='font-size: 11px;'></i> {$post['nome']}";
                            }else{

                                echo $catPost['nome'];
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="col-xs-12 hidden-sm hidden-md hidden-lg text-center">
                    <div class="data-post-xs">
                        <?php 
                        $data = explode("-", $post['data']);
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
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="post">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                            <h2 style="text-decoration: none; color: <?php echo $arrayPost['cor_titulo'] ?>">
                                <?php echo $post['nome']; ?>
                            </h2>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <?php echo $post['descricao']; ?>
                        </div>
                        <br/>
                        <?php
                        //valida se a galeria está ativa
                        if($post['album'] == 1){
                        ?>
                        <div class="row">
                            <?php 
                            //sql do album
                            $sqlAlbum = mysql_query(" SELECT * FROM blog_foto WHERE id_pasta = {$post['id']} ORDER BY ordem ASC ");
                            while($album = mysql_fetch_assoc($sqlAlbum)){
                                
                                $imgAlbum = "admin/image/blog/{$post['id']}/{$album['id']}xs.jpg";
                                $imgAlbumLG = "admin/image/blog/{$post['id']}/{$album['id']}lg.jpg";
                                if(file_exists($imgAlbum)){
                            ?>
                            <div class="col-xs-4 col-sm-2 col-md-2 col-lg-2 text-center">
                                <a href="<?php echo $imgAlbumLG; ?>" class="fancybox" data-fancybox-group="<?php echo $post['nome']; ?>">
                                    <img src="<?php echo $imgAlbum; ?>" class="img-responsive" />
                                </a>
                            </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                        <?php    
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php if($post['comentario'] == 1){ ?>
            <?php if($_POST['msg1'] || $_POST['msg2'] || $_POST['msg3'] || $_POST['msg4']){ ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 error">
                <br/>
                <?php if($_POST['msg1']){ ?><div class="alert alert-success no-radius"><?php echo $_POST['msg1']; ?></div><?php } ?>
                <?php if($_POST['msg2']){ ?><div class="alert alert-danger no-radius"><?php echo $_POST['msg2']; ?></div><?php } ?>
                <?php if($_POST['msg3']){ ?><div class="alert alert-warning no-radius"><?php echo $_POST['msg3']; ?></div><?php } ?>
                <?php if($_POST['msg4']){ ?><div class="alert alert-danger no-radius"><?php echo $_POST['msg4']; ?></div><?php } ?>
            </div>
            <?php } ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="box-descricao-produto">
                    <form method="post" action="" class="form-comentario" id="form-comentario">
                        <div id="review">
                            <?php
                            $contComment = mysql_num_rows(mysql_query(" SELECT * FROM comentario WHERE id_post = {$post['id']} AND ativo = 1 "));
                            if($contComment > 0){
                            ?>
                            <div class='box-titulo acessar acessar-cad no-padding no-margin text-center'>
                                <div class='titulo-line'></div>
                                <h3 class='titulo'>COMENTÁRIOS</h3>
                            </div>
                            <?php
                            $sql3 = mysql_query(" SELECT * FROM comentario WHERE id_post = {$post['id']} AND ativo = 1 ORDER BY data ASC ");
                            $contComment = mysql_num_rows($sql3);
                            $iComment=1;
                            while($array3 = mysql_fetch_assoc($sql3)){
                            ?>
                            <table border="0" cellspacing="0" cellpading="0" width="100%" class="fontSizeComments" style="margin-bottom: 15px;">
                                <tbody>
                                    <tr>
                                        <td><strong><?php echo $array3['nome']; ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td class="descComment">
                                            <?php echo $array3['descricao']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="writeComment"><i class="fa fa-user"></i> Esse comentário foi escrito em <?php echo dataNormal($array3['data']); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php
                                if($iComment != $contComment){
                                    echo "<tr>";
                                        echo "<td>";
                                            echo "<div class='border-separator-comment'></div>";
                                        echo "</td>";        
                                    echo "</tr>";
                                }
                                $iComment++;
                            }
                            }
                            ?>
                        </div>
                        <br/><br/>
                        <div class="row" id="comentario">
                            <input type="hidden" name="id_post" value="<?php echo $post['id']; ?>" />
                            <div class="col-md-12 text-center">
                                <div class='box-titulo acessar acessar-cad no-padding no-margin'>
                                    <div class='titulo-line'></div>
                                    <h3 class='titulo'>FAÇA SEU COMENTÁRIO</h3>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="nome">Seu nome <span class='obg'>*</span></label>
                                    <input type="text" name="nome" value="" id="nome" required class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="email">Seu e-mail <span class='obg'>*</span></label>
                                    <input type="email" name="email" value="" id="email" required class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label" for="descricao">Seu comentário <span class='obg'>*</span></label>
                                    <textarea name="descricao" rows="5" id="descricao" class="form-control resize" style="resize: none;" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div id="captcha1" style="margin-bottom: 15px;"></div>
                                    <div class="clearfix"></div>
                                    <button type="submit" id="button-review" class="btn btn-voltar" name="comentario" value="1">Continuar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php } ?>
            <?php if($post['formulario'] == 1){ ?>
            <?php if($_POST['msg1'] || $_POST['msg2'] || $_POST['msg3'] || $_POST['msg4']){ ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 error">
                <br/>
                <?php if($_POST['msg1']){ ?><div class="alert alert-success no-radius"><?php echo $_POST['msg1']; ?></div><?php } ?>
                <?php if($_POST['msg2']){ ?><div class="alert alert-danger no-radius"><?php echo $_POST['msg2']; ?></div><?php } ?>
                <?php if($_POST['msg3']){ ?><div class="alert alert-warning no-radius"><?php echo $_POST['msg3']; ?></div><?php } ?>
                <?php if($_POST['msg4']){ ?><div class="alert alert-danger no-radius"><?php echo $_POST['msg4']; ?></div><?php } ?>
            </div>
            <?php } ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="box-descricao-produto">
                    <form method="post" action="" class="form-comentario" id="form-contato">
                        <div class="row">
                            <input type="hidden" name="id_categoria" value="<?php echo $post['id_categoria']; ?>" />
                            <div class="col-md-12 text-center">
                                <div class='box-titulo acessar acessar-cad no-padding no-margin'>
                                    <div class='titulo-line'></div>
                                    <h3 class='titulo'>ENTRE EM CONTATO</h3>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="nome">Seu nome <span class='obg'>*</span></label>
                                    <input type="text" name="nome" value="" id="nome" required class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="email">Seu e-mail <span class='obg'>*</span></label>
                                    <input type="email" name="email" value="" id="email" required class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label " for="fone">Seu telefone <span class='obg'>*</span></label>
                                    <input type="text" name="fone" value="" id="fone" required class="form-control telefone" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label" for="descricao">Sua mensagem<span class='obg'>*</span></label>
                                    <textarea name="descricao" rows="5" id="descricao" class="form-control resize" style="resize: none;" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div id="captcha1" style="margin-bottom: 15px;"></div>
                                    <div class="clearfix"></div>
                                    <button type="submit" id="button-review" class="btn btn-voltar" name="contato" value="1">Continuar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php } ?>
            <!--tags e compartilhamento-->
            <div class="row">
                <div class="hidden-xs col-sm-12 col-md-12 col-lg-12">
                    <div class="box-line-leia-mais">
                        <div class="full-line"></div>
                        <a class="a-leia-mais" href="<?php echo "blog/1"; ?>">VOLTAR</a>
                    </div>
                </div>
                <div class="col-xs-12 hidden-sm hidden-md hidden-lg">
                    <div class="box-line-leia-mais" style="margin-bottom: 18px;">
                        <div class="full-line" style="width: 90%;"></div>
                        <a class="a-leia-mais" href="<?php echo "blog/1/"; ?>">VOLTAR</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="hidden-xs col-sm-6 col-md-6 col-lg-6 text-left">
                    <?php if($post['tags']){ ?>
                    <div class="box-tags-compartilhar">
                        <i class="fa fa-tag"></i> Tags:
                        <?php
                        $tags = explode(",", $post['tags']);
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
                            <?php if($post['facebook_compartilhar'] == 1){ ?>
                            <div class="">
                                <i class="fa fa-share-alt"></i> Compartilhe: 
                                <?php if($post['facebook_compartilhar'] == 1){ ?>
                                <a href="<?php echo "http://facebook.com/sharer.php?u={$configuracao['url_global']}facebook/facebook.php?id={$post['id']}"; ?>" class="a-compartilhe-post" target="_blank"><i class="fa fa-facebook"></i></a>
                                <?php } ?>

                                <?php if($post['twitter_compartilhar'] == 1){ ?>
                                <a href="<?php echo "http://twitter.com/home?status={$configuracao['url_global']}blog/1/{$post['id']}/{$post['slugify']}"; ?>" class="a-compartilhe-post" target="_blank"><i class="fa fa-twitter"></i></a>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <!--XS---------------------->
                <div class="col-xs-12 hidden-sm hidden-md hidden-lg text-center">
                    <?php if($post['tags']){ ?>
                    <div class="box-tags-compartilhar">
                        <i class="fa fa-tag"></i> Tags:
                        <?php
                        $tags = explode(",", $post['tags']);
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
                    <?php if($post['facebook_compartilhar'] == 1){ ?>
                    <div class="box-tags-compartilhar">
                        <i class="fa fa-share-alt"></i> Compartilhe: 
                        <?php if($post['facebook_compartilhar'] == 1){ ?>
                        <a href="<?php echo "http://facebook.com/sharer.php?u={$configuracao['url_global']}facebook/facebook.php?id={$post['id']}"; ?>" class="a-compartilhe-post" target="_blank"><i class="fa fa-facebook"></i></a>
                        <?php } ?>

                        <?php if($post['twitter_compartilhar'] == 1){ ?>
                        <a href="<?php echo "twitter.com/home?status={$configuracao['url_global']}blog/1/{$post['id']}/{$post['slugify']}"; ?>" class="a-compartilhe-post" target="_blank"><i class="fa fa-twitter"></i></a>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--<div class="row">
    <div class="hidden-xs col-sm-6 col-md-6 col-lg-6 text-left">
        <a href="" class="btn btn-voltar">ANTERIOR</a>
    </div>
    <div class="hidden-xs col-sm-6 col-md-6 col-lg-6 text-right">
        <a href="" class="btn btn-voltar">PRÓXIMA</a>
    </div>
</div>-->
<?php
//sql com mais posts da mesma categoria
$sql = mysql_query(" SELECT * FROM blog WHERE ativo = 1 AND id_categoria = {$post['id_categoria']} AND id <> {$post['id']} ORDER BY data DESC LIMIT 3 ");

//valida se tem posts
$validaDestaque = mysql_num_rows($sql);
$i = 0;
while($array = mysql_fetch_assoc($sql)){
    $img = "admin/image/blog/{$array['id']}/{$array['id']}thumb.jpg";
    if(file_exists($img)){
        $arrFotos[$i]['id'] .= $array['id'];
        $arrFotos[$i]['nome'] .= $array['nome'];
        $arrFotos[$i]['slugify'] .= $array['slugify'];
        $arrFotos[$i]['foto'] .= "admin/image/blog/{$array['id']}/{$array['id']}thumb.jpg";
        $i++;
    }
}
$contadorFotos = count($arrFotos);
if($validaDestaque && $contadorFotos > 0){
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box-posts borders">
            <div class="row">
                <div class="hidden-xs col-sm-12 col-md-12 col-lg-12 text-left">
                    <div class="tag-categoria">CONFIRA TAMBÉM</div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php
                $j = 0;
                while($j != $contadorFotos){
                ?>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="padding-top: 10px;">
                    <a href="<?php echo "blog/1/{$arrFotos[$j]['id']}/{$arrFotos[$j]['slugify']}"; ?>" class="a-block">
                        <img src="<?php echo $arrFotos[$j]['foto']; ?>" class="img-responsive auto" alt="<?php echo $arrFotos[$j]['nome']; ?>" />
                        <h5><?php echo $arrFotos[$j]['nome']; ?></h5>
                    </a>
                    </div>
                <?php
                $j++  ;              
                }
                ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>