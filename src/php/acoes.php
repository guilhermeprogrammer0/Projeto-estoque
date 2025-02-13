<?php
require_once "funcoes.php";
require_once "conexao.php";
if($_POST['categoria']){
    $_SESSION['categoria-selecionada'] = $_POST['idCategoria'];
    ?>
    <script>window.location.href = "lista_produtos.php"</script> 
    <?php
}
if($_POST['editar_Estoque']){
    gerenciar_estoque($conexao,$_POST['tipo'],$_POST['qtd_movida'],$_SESSION['produto_selecionado']);
}
if($_POST['escolha_cadastro']){
    $_SESSION['categoria_cadastro'] =  $_POST['categoria_cadastro'];
    header("location:cadastro_produtos.php");
}
if($_POST['cadastrar_produtos']){
    if($_SESSION['categoria_cadastro'] == 'categoria'){
        cadastrar_categoria($conexao,$_POST['nomeCategoria']);
        ?>
        <script>window.location.href = "escolha_categoria_cadastro.php"</script> 
         <?php
    }
    else if($_SESSION['categoria_cadastro'] == 'produtos'){
        cadastrar_produto($conexao,$_POST['nome'],$_POST['quantidade'],$_POST['valor'],$_POST['imagem'],$_POST['idCategoria']);
        ?>
   <script>window.location.href = "escolha_categoria.php"</script> 
    <?php
    }
    unset($_SESSION['categoria_cadastro']);
}
if($_POST['cadastrar']){
    cadastrar_usuario($conexao,$_POST['nome'],$_POST['usuario'],$_POST['senha']);
}
if($_POST['login']){
    fazer_login($conexao,$_POST['usuario'],$_POST['senha']);
}
?>