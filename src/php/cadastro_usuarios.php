<?php
require_once "conexao.php";
require_once "funcoes.php";
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://kit.fontawesome.com/ae27920976.js" crossorigin="anonymous"></script>
</head>
<body class="fundo">
    <main class="formularioGeral">
        <div>
            <h1>Cadastro</h1>
        </div>
        <form action="acoes.php" method="POST">
            <div class="formulario">
                <label for="nome" class="form-label">Nome</label>
                <div class="mb-3">
                    <input type="text" name="nome" id="nome" required maxlength="50">
                </div>
                <label for="usuario" class="form-label">Usuário</label>
                <div class="mb-3">
                    <input type="text" name="usuario" id="usuario" required maxlength="100">
                </div>
                <label for="senha" class="form-label">Senha</label>
                <div class="mb-3">
                    <input type="password" name="senha" id="senha" required maxlength="100">
                </div>
                <div class="mb-3">
                    <input type="submit" class="botao botaoEnviar" value="Cadastrar" name="cadastrar" />
                </div>
                <div class="mb-3 link-cadastro">
                    <p><a href="login.php">Entrar</a></p>
                </div>
            </div>
        </form>
    </main>
</body>
</html>