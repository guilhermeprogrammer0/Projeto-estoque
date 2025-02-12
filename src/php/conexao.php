<?php
$conexao = new mysqli("localhost","root","","controle-esoque");
if($conexao->connect_error){
    echo "Erro: " . $conexao->connect_error();
}


?>