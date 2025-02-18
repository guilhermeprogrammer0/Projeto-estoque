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
    <title>Escolha de categoria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://kit.fontawesome.com/ae27920976.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <div>
            <h1>Gestão de estoque</h1>
        </div>
        <div class="avatarUser">
            <div>
                <?php mostrar_nome($_SESSION['nome_usuario_logado']); ?>
            </div>
        </div>
        <div>
            <div class="btnSair">
                <a href="sair.php"><i class="fa-solid fa-right-from-bracket fa-2x"></i> </a>
            </div>
    </header>
    <main class="menu-principal">
        <div class="menu-lateral">
            <?php include_once "nav.php"; ?>
        </div>
        <div class="area-exibicao main-categoria">
            <h1>Qual produto gostaria de ver?</h1>
            <div class="escolha-categoria">
                <form action="acoes.php" method="POST">
                    <?php listar_categoria($conexao); ?>
                    <div>
                        <input type="submit" class="botao botaoEnviar" value="Enviar" name="categoria" />
                    </div>
                </form>

                </select>
            </div>
        </div>
    </main>
</body>
</html>