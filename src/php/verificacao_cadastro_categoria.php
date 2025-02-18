<?php
if(!isset($_SESSION['categoria_cadastro']) || $_SESSION['categoria_cadastro']!= 'produtos'){
    header("location:escolha_categoria_cadastro.php");
}
?>