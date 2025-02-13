<?php
require_once "conexao.php";
require_once "funcoes.php";
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
                <h4>Olá, Guilherme!</h4>
            </div>
            <div class="btnSair">
            <i class="fa-solid fa-right-from-bracket fa-2x"></i>
            </div>
        </div>
    </header>
    <main class="menu-principal menu-principal-cadastro">
        <div class="menu-lateral menu-lateral-cadastro">
            <nav>
                <ul class="menu">
                    <li> <a href="cadastro_produtos.php">Cadastrar Produtos </a></li>
                    <li><a href="escolha_categoria.php">Produtos</a></li>
                    <li><a href="#">Cadastrar funcionários</a></li>
                    <li><a href="#">Alterar login</a></li>
                    <li><a href="#">Excluir conta</a></li>
                </ul>
            </nav>
        </div>
        <div class="area-exibicao main-cadastro-produto">
            <div class="cadastro-produto">
                <form action="acoes.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome">
                </div>
                <div class="mb-3">
                <label for="Quantidade" class="form-label">Quantidade</label>
                <input type="text" class="form-control" id="Quantidade" name="quantidade">
                </div>
                <div class="mb-3">
                <label for="valor" class="form-label">Valor</label>
                <input type="text" class="form-control" id="valor" name="valor">
                </div>
                <div class="mb-3">
                <label for="imagem" class="form-label">Imagem</label>
                <input type="file" class="form-control" id="imagem" name="imagem">
                </div>
                <div class="mb-3">
                <label  class="form-label">Categoria</label>
               <?php listar_categoria($conexao);?>
                </div>
                <div>
                    <input type="submit" class="botaoEnviarCategoria" value="Enviar" name="cadastrar_produtos"/>
                </div>
</form>


            </div>
        </div>

    </main>
    
</body>
</html>