<?php
require_once "funcoes.php";
require_once "conexao.php";
require_once "verificacao_login.php";
$id_produto = $_POST['id'];
$_SESSION['produto_selecionado'] = $id_produto;
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edição de estoque</title>
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
    <main class="menu-principal">
        <div class="menu-lateral">
            <?php include_once "nav.php"; ?>
        </div>
        <div class="area-exibicao area-edicao-estoque">
            <div class="edicao-estoque">
                <?php listar_produto($conexao, $id_produto); ?>
                <form action="acoes.php" method="POST">
                    <div class="form-edicao-estoque">
                        <select class="form-select mb-3 lista-edicao-estoque" aria-label="Large select example" name="tipo" required>
                            <option selected>Tipo</option>
                            <option value="entrada">Entrada</option>
                            <option value="saida">Saída</option>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="qtd_movida" name="qtd_movida" placeholder="Quantidade" required>
                            </div>
                            <div class="mb-3 mb-3-botoes">
                                <a href="lista_produtos.php"><button type="button" class="botao botaoCancelar"> Cancelar </button></a>
                                <input type="submit" class="botao botaoEnviar" value="Enviar" name="editar_Estoque" />
                            </div>
                    </div>
            </div>
            </form>
            </select>
        </div>
        </div>
    </main>
</body>
</html>