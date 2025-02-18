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
            <div class="cadastro-produto cadastro-categoria">
                <form action="acoes.php" method="POST">
                    <div class="mb-3 cadastrar-categoria">
                        <label for="nomeCategoria" class="form-label categoria">Nome Categoria</label>
                        <input type="text" class="form-control" id="nomeCategoria" name="nomeCategoria" maxlength="100">
                    </div>
                    <div class="mb-3">
                        <a href="escolha_categoria_cadastro.php"><button type="button" class="botao botaoCancelar"> Cancelar </button></a>
                        <input type="submit" class="botao botaoEnviar" value="Cadastrar" name="cadastrar_categoria">
                    </div>
                </form>
                <div class="mb-3 cadastrar-categoria">
                    <?php
                    $sql = "SELECT * FROM categoria";
                    $resultado = $conexao->query($sql); ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($linha = $resultado->fetch_array()) { ?>
                                <tr>
                                    <td><?php echo $linha['nomeCategoria']; ?></td>
                                    <td>
                                        <form action="acoes.php" method="POST" onsubmit="return confirm('Deseja mesmo excluir?')">
                                            <input type="hidden" name="idCategoria" value="<?php echo $linha['idCategoria']; ?>">
                                            <button type="submit" class="fa-solid fa-x btnExcluirCategoria" name="btnExcluirCategoria"></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>

</html>