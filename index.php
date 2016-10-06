<?php require_once 'require.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <!--BASE-->
        <base href="<?php echo $configuracao['url_global']; ?>" />
        <!--METAS-->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="index,follow" />
        <meta name="googlebot" content="index,follow" />
        <meta name="revisit-after" content="" />
        <meta name="RATING" CONTENT="general" />
        <meta name="DISTRIBUTION" CONTENT="global" />
        <meta name="LANGUAGE" CONTENT="PT" />
        <meta name="author" content="Ydeal Tecnologia" />
        <?php if(is_numeric($_GET['pg3']) && is_string($_GET['pg4'])){ ?>
        
            <?php 
            $seoPost = busca_array_sql("blog", "id", $_GET['pg3']);
            if($seoPost['seo_descricao']){
            ?>
                <meta name="description" content="<?php echo $seoPost['seo_descricao']; ?>" />
            <?php
            }else{
            ?>
                <meta name="description" content="<?php echo $configuracao['nome']; ?>" />
            <?php 
            }
            ?>
                
            <?php if($seoPost['nome']){ ?>
                <title><?php echo $seoPost['nome']; ?></title>
            <?php }else{ ?>
                <title><?php echo $configuracao['nome']; ?></title>
            <?php } ?>
            
        <?php }else{ ?>
            <meta name="description" content="<?php echo $configuracao['nome']; ?>" />
            <title><?php echo $configuracao['nome']; ?></title>
        <?php } ?>
        <!--LINKS-->
        <link rel="shortcut icon" href="./admin/image/configuracao/1-favicon.png" type="image/x-icon" /><!-- Favicon -->
        <link href='<?php echo $layout_fonte['link_fonte']; ?>' rel='stylesheet' type='text/css'>
        <link href="./css/bootstrap/fonts-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="./js/fancy/source/jquery.fancybox.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="css/owl.carousel.css"/> 
        <link href="./css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="./css/header/header_1.css" rel="stylesheet">
        <link href="./css/footer/footer_1.css" rel="stylesheet">
        <link href="./css/style.css" rel="stylesheet">
        <?php require_once "./css/style.php"; ?>
        <style>
        body{
        font-weight: <?php echo $layout_fonte['fonte_normal']; ?>;
        <?php echo $layout_fonte['nome_fonte']; ?>
        }
        </style>
        <?php echo $configuracao_servidor['google_analytics']; ?>
    </head>
    <body>
        <?php
        //inclui o cabecalho
        require_once './template/header/header_1.php';
        
        //valida se existe o arquivo da pagina criado;
        if (file_exists("blog.php")) {
            require_once 'blog.php';
        } else {
            require_once 'error.php';
        }

        //inclui o rodape
        require_once './template/footer/footer_1.php';
        ?>
        <!--JQUERY-->
        <script src="./js/jquery/jquery-2.2.4.min.js"></script>
        <script src="./js/bootstrap/bootstrap.min.js"></script>
        <script type="text/javascript" src="./js/owl.carousel.min.js"></script>
        <script type="text/javascript" src="./js/fancy/source/jquery.fancybox.js?v=2.1.5"></script>
        <script type="text/javascript">
        $(document).ready(function() {
            
            //carousel mobile
            $('#slideshow0').owlCarousel({
                items: 3,
                autoPlay: 3000,
                singleItem: true,
                navigation: true,
                navigationText: ['<i class="fa fa-chevron-left fa-5x"></i>', '<i class="fa fa-chevron-right fa-5x"></i>'],
                pagination: false
            });    
            
            //galeria starter
            $('.fancybox').fancybox();
            
        });
        </script>
        <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
        <script>
        var widgetId1;
        var widgetId2;
        var onloadCallback = function() {
          // Renders the HTML element with id 'example1' as a reCAPTCHA widget.
          // The id of the reCAPTCHA widget is assigned to 'widgetId1'.
          widgetId1 = grecaptcha.render('captcha1', {
            'sitekey' : '6LeBIxkTAAAAAIn6mcS9rddtP986bjp1-ZdzshGh',
            'theme' : 'light'
          });
          widgetId2 = grecaptcha.render(document.getElementById('captcha2'), {
            'sitekey' : '6LeBIxkTAAAAAIn6mcS9rddtP986bjp1-ZdzshGh',
            'theme' : 'light'
          });
        };    
        </script>
    </body>
</html>