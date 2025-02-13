<?php
require_once "conexao.php";
require_once "funcoes.php";
require_once "verificacao_cadastro_categoria.php";
require_once "verificacao_login.php";
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://kit.fontawesome.com/ae27920976.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <h1>Gestão de estoque</h1>
        <div class="avatarUser">
            <div>
            <?php mostrar_nome($_SESSION['nome_usuario_logado']);?>
            </div>
            <div class="btnSair">
            <a href="sair.php"><i class="fa-solid fa-right-from-bracket fa-2x"></i> </a>
            </div>
        </div>
    </header>
    <main class="menu-principal menu-principal-cadastro">
        <div class="menu-lateral menu-lateral-cadastro">
        <nav>
                <ul class="menu">
                    <li> <a href="escolha_categoria_cadastro.php">Cadastrar Produtos </a></li>
                    <li><a href="escolha_categoria.php">Produtos</a></li>
                    <li><a href="movimentacoes.php">Movimentações</a></li>
                    <li><a href="cadastro_usuarios.php">Cadastrar funcionários</a></li>
                    <li><a href="#">Alterar login</a></li>
                    <li><a href="#">Excluir conta</a></li>
                </ul>
            </nav>
        </div>
        <div class="main-categoria main-categoria2">
            <div class="cadastro-produto">
            <form action="acoes.php" method="POST" enctype="multipart/form-data">
                <?php exibir_escolha_categoria($conexao,$_SESSION['categoria_cadastro']);
                ?>
                <div>
                    <input type="submit" class="botaoEnviar" value="Enviar" name="cadastrar_produtos"/>
                </div>
            </form>
            </select>
            </div>       
            </div>
    </main>
    
</body>
</html>