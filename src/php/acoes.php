<?php
require_once "funcoes.php";
require_once "conexao.php";
if($_POST['categoria']){
    $_SESSION['categoria-selecionada'] = $_POST['cat'];
    ?>
    <script>window.location.href = "lista_produtos.php"</script> 
    <?php
}
if($_POST['cadastrar_produtos']){
    cadastrar_produto($conexao,$_POST['nome'],$_POST['quantidade'],$_POST['valor'],$_POST['imagem'],$_POST['idCategoria']);
    ?>
   <script>window.location.href = "escolha_categoria.php"</script> 
    <?php
}
if($_POST['editar_Estoque']){
    gerenciar_estoque($conexao,$_POST['tipo'],$_POST['qtd_movida'],$_SESSION['produto_selecionado']);
}
?>