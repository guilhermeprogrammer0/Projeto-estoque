<?php
require_once "conexao.php";
require_once "funcoes.php";
require_once "verificacao_login.php";
?>
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edição de produtos</title>
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
            <?php exibir_dados_alteracao($conexao, $_POST['id']); ?>
    </main>
</body>
</html>