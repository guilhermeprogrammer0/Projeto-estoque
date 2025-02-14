<?php
require_once "conexao.php";
require_once "funcoes.php";
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
    <main class="menu-principal">
        <div class="menu-lateral">
        <nav>
                <ul class="menu">
                    <li> <a href="cadastro_produtos.php">Cadastrar Produtos </a></li>
                    <li><a href="escolha_categoria.php">Produtos</a></li>
                    <li><a href="movimentacoes.php">Movimentações</a></li>
                    <li><a href="cadastro_usuarios.php">Cadastrar funcionários</a></li>
                    <li><a href="perfil.php">Meu perfil</a></li>
                </ul>
            </nav>
        </div>
        <div class="main-categoria main-categoria2">
            <h1>O que você quer cadastrar?</h1>
            <div class="escolha-categoria">
                <form action="acoes.php" method="POST">
            <select class="form-select form-select-lg mb-3" aria-label="Large select example" name="categoria_cadastro">
                <option selected>Cadastrar</option>
                <option value="categoria">Categorias</option>
                <option value="produtos">Produtos</option>
                <div>
                    <input type="submit" class="botaoEnviar" value="Enviar" name="escolha_cadastro"/>
                </div>
            </form>
            </select>
            </div>       
            </div>
    </main>
    
</body>
</html>