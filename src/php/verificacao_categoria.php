<?php
require_once "funcoes.php";
if(!isset($_SESSION['categoria-selecionada'])){
    header("location:escolha_categoria.php");
}

?>