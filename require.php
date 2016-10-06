<?php

//inclui arquivos padrao;
require_once './admin/conexao.php';
require_once './admin/funcoes/sql.php';
require_once './admin/funcoes/gerenciaPost.php';

//retorna informacoes padrao em forma de array;
$configuracao = busca_array_sql("configuracao", "id", 1);
$configuracao_email = busca_array_sql("configuracao_email", "id", 1);
$configuracao_servidor = busca_array_sql("configuracao_servidor", "id", 1);
$layout_geral = busca_array_sql("layout_geral", "id", 1);
$layout_cabecalho = busca_array_sql("layout_cabecalho", "id", 1);
$layout_menu = busca_array_sql("layout_menu", "id", 1);
$layout_fonte = busca_array_sql("layout_fonte", "id", 1);

//atribui pagina padrao;
if (empty($_GET['pg'])) {

    $_GET['pg'] = "blog";
    $_GET['pg2'] = "/1";
    echo "<script>location.href='{$configuracao['url_global']}{$_GET['pg']}{$_GET['pg2']}'</script>";
}