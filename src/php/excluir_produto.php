<?php
require_once "conexao.php";
$id_produto = $_REQUEST['id_produto_excluir'];
if($id_produto){
    excluir_produto($conexao,$id_produto);
}

?>