<?php
session_start();
if(!isset($_SESSION['categoria-selecionada'])){
    header("location:escolha_categoria.php");
}

?>