<?php
require_once "conexao.php";
require_once "verificacao_categoria.php";
?>
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de produtos</title>
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
    <main class="menu-principal">
        <div class="menu-lateral">
            <nav>
                <ul class="menu">
                    <li> <a href="cadastro_produtos.php">Cadastrar Produtos </a></li>
                    <li><a href="escolha_categoria.php">Produtos</a></li>
                    <li><a href="movimentacoes.php">Movimentações</a></li>
                    <li><a href="#">Cadastrar funcionários</a></li>
                    <li><a href="#">Alterar login</a></li>
                    <li><a href="#">Excluir conta</a></li>
                </ul>
            </nav>
        </div>
        <div class="area-exibicao main-produtos">
           <?php 
           $sql = "SELECT p.id, p.nome, p.quantidade, p.valor,p.imagem FROM produtos p
           INNER JOIN categoria c
           ON p.idCategoria = c.idCategoria
           WHERE c.idCategoria = ?";
           $stmt_categoria = $conexao->prepare($sql);
           $stmt_categoria->bind_param("s",$_SESSION['categoria-selecionada']);
           $stmt_categoria->execute();
           $resultado = $stmt_categoria->get_result();
           if($resultado->num_rows==0){
            ?>
            <div class="alert alert-primary" role="alert">
                Sem produtos
            </div>
            <?php
           }
            while($linha = $resultado->fetch_array()){
                $img = "../Upload/" . $linha['imagem'];
                ?>
                <div class="card card-imagem">
                <img src="<?php echo $img ?>" class="card-img-top img-produto" alt="<?php echo $linha['nome'];?>">
                <i class="fa-solid fa-x  btnExcluirProduto"></i>
                <div class="card-body">
                 <h5 class="card-title">Nome: <?php echo $linha['nome'];?></h5>
                <p class="card-text">Quantidade atual: <?php echo $linha['quantidade'];?></p>
                <p class="card-text">Valor: R$<?php echo number_format($linha['valor'],2,',','.');?></p>
                <button class="btn btn-warning" onclick="editarEstoque(<?php echo $linha['id'];?>)">Editar estoque </button>
  </div>
</div>
            <?php
            }
            ?>
        </div>

    </main>
    <script src="../js/acoes.js"></script>
</body>
</html>