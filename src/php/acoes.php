<?php
session_start();
if($_POST['categoria']){
    $_SESSION['categoria-selecionada'] = $_POST['cat'];
    header("location: lista_produtos.php");
}
?>