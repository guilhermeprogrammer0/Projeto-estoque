<?php
$conexao = new mysqli("localhost","root","","controle_estoque");
if($conexao->connect_error){
    echo "Erro: " . $conexao->connect_error();
}


?>