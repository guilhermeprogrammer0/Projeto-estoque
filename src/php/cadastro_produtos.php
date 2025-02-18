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
                <?php mostrar_nome($_SESSION['nome_usuario_logado']); ?>
            </div>
        </div>
        <div class="btnSair">
            <a href="sair.php"><i class="fa-solid fa-right-from-bracket fa-2x"></i> </a>
        </div>
    </header>
    <main class="menu-principal menu-principal-cadastro">
        <div class="menu-lateral menu-lateral-cadastro">
            <?php include_once "nav.php"; ?>
        </div>
        <div class="main-categoria main-categoria2">
            <div class="cadastro-produto">
                <form action="acoes.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" required maxlength="100">
                    </div>
                    <div class="mb-3">
                        <label for="Quantidade" class="form-label">Quantidade</label>
                        <input type="text" class="form-control" id="Quantidade" name="quantidade" required>
                    </div>
                    <div class="mb-3">
                        <label for="valor" class="form-label">Valor</label>
                        <input type="text" class="form-control" id="valor" name="valor" required>
                    </div>
                    <div class="mb-3">
                        <label for="imagem" class="form-label">Imagem</label>
                        <input type="file" class="form-control" id="imagem" name="imagem" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Categoria</label>
                        <?php listar_categoria($conexao); ?>
                    </div>
                    <div class="mb-3">
                        <a href="escolha_categoria_cadastro.php"><button type="button" class="botao botaoCancelar"> Cancelar </button></a>
                        <input type="submit" class="botao botaoEnviar" value="Cadastrar" name="cadastrar_produtos">
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>