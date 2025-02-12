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
                    <li> <a href="#">Cadastrar Produtos </a></li>
                    <li><a href="escolha_categoria.php">Exibir produtos</a></li>
                    <li><a href="#">Cadastrar funcionários</a></li>
                    <li><a href="#">Alterar login</a></li>
                    <li><a href="#">Excluir conta</a></li>
                </ul>
            </nav>
        </div>
        <div class="area-exibicao main-categoria">
            <h1>Escolha a categoria do produto</h1>
            <div class="escolha-categoria">
                <form action="acoes.php" method="POST">
            <select class="form-select form-select-lg mb-3" aria-label="Large select example" name="cat">
                <option selected>Categoria</option>
                <option value="desktop">Desktops</option>
                <option value="notebook">Notebooks</option>
                <option value="celular">Celulares</option>
                <option value="tablet">Tablets</option>
                <div>
                    <input type="submit" class="botaoEnviarCategoria" value="Enviar" name="categoria"/>
                </div>
</form>

</select>
            </div>
        </div>

    </main>
    
</body>
</html>