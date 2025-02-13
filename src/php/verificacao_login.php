<?php
require_once "funcoes.php";
if(!isset($_SESSION['usuario_logado'])){
    header("location:login.php");
}

?>