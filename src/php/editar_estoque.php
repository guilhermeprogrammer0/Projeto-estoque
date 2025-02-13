<?php
require_once "funcoes.php";
require_once "conexao.php";
require_once "verificacao_login.php";
$id_produto = $_REQUEST['id'];
$_SESSION['produto_selecionado'] = $id_produto;
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
                    <li><a href="#">Alterar login</a></li>
                    <li><a href="#">Excluir conta</a></li>
                </ul>
            </nav>
        </div>
        <div class="area-exibicao area-edicao-estoque">
            <div class="edicao-estoque">
            <?php listar_produto($conexao,$id_produto);?>
                <form action="acoes.php" method="POST">
                    <div class="form-edicao-estoque">
                    <select class="form-select mb-3 lista-edicao-estoque" aria-label="Large select example" name="tipo">
                    <option selected>Tipo</option>
                    <option value="entrada">Entrada</option>
                    <option value="saida">Saída</option>
                    <div class="mb-3">
                    <input type="text" class="form-control" id="qtd_movida" name="qtd_movida" placeholder="Quantidade">
                    </div>
                 <div class="mb-3">
                    <input type="submit" class="botaoEnviar" value="Enviar" name="editar_Estoque"/>
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