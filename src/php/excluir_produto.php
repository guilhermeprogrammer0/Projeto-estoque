<?php
require_once "conexao.php";
require_once "funcoes.php";
$id_produto = $_REQUEST['id_produto_excluir'];
excluir_produto($conexao,$id_produto);


?>