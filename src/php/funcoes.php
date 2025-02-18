<?php
session_start();
function cadastrar_produto($conexao, $nome, $quantidade, $valor, $imagem, $idCategoria)
{
    $arquivo = $_FILES['imagem'];
    $nomeImagem = $arquivo['name'];
    $tmp_name = $arquivo['tmp_name'];
    $extensao = pathinfo($nomeImagem, PATHINFO_EXTENSION);
    $novo_nome = uniqid() . "." . $extensao;
    move_uploaded_file($tmp_name, '../Upload/' . $novo_nome);
    $sql_cadastrar = "INSERT INTO produtos VALUES (default,?,?,?,?,?)";
    $stmt_cadastrar = $conexao->prepare($sql_cadastrar);
    $stmt_cadastrar->bind_param("sidsi", $nome, $quantidade, $valor, $novo_nome, $idCategoria);
    if ($stmt_cadastrar->execute()) {
?>
        <script>
            alert("Produto cadastrado com sucesso");
            window.location.href = 'escolha_categoria.php';
        </script>
    <?php
    }

    $stmt_cadastrar->close();
}
function editar_produto($conexao, $id_produto, $nome, $valor, $imagem, $id_categoria)
{
    $arquivo = $_FILES['imagem'];
    $nomeImagem = $arquivo['name'];
    $tmp_name = $arquivo['tmp_name'];
    $extensao = pathinfo($nomeImagem, PATHINFO_EXTENSION);
    $novo_nome = uniqid() . "." . $extensao;
    move_uploaded_file($tmp_name, '../Upload/' . $novo_nome);
    if ($arquivo['size'] > 0) {
        $sql_editar = "UPDATE produtos set nome = ?, valor = ?, imagem = ?, idCategoria = ? WHERE id = ?";
        $stmt_editar = $conexao->prepare($sql_editar);
        $stmt_editar->bind_param("sdsii", $nome, $valor, $novo_nome, $id_categoria, $id_produto);
    } else {
        $sql_editar = "UPDATE produtos set nome = ?, valor = ?, idCategoria = ? WHERE id = ?";
        $stmt_editar = $conexao->prepare($sql_editar);
        $stmt_editar->bind_param("sdii", $nome, $valor, $id_categoria, $id_produto);
    }
    if ($stmt_editar->execute()) {
        $_SESSION['categoria-selecionada'] = $id_categoria;
    ?>
        <script>
            alert("Produto alterado com sucesso!")
            window.location.href = "lista_produtos.php";
        </script>
        <?php
    } else {
        echo "ERRO!" . $stmt_editar->error;
    }
    $stmt_editar->close();
}
function excluir_produto($conexao, $id_produto)
{
    $sql_desassociar = "UPDATE movimentacao_estoque set idProduto = NULL WHERE idProduto = ?";
    $stmt_desassociar = $conexao->prepare($sql_desassociar);
    $stmt_desassociar->bind_param("i", $id_produto);
    if ($stmt_desassociar->execute()) {
        $sql_excluir = "DELETE FROM produtos WHERE id = ?";
        $stmt_excuir = $conexao->prepare($sql_excluir);
        $stmt_excuir->bind_param("i", $id_produto);
        if ($stmt_excuir->execute()) {
        ?>
            <script>
                alert("Produto excluído com sucesso!")
                window.location.href = "lista_produtos.php";
            </script>
        <?php
        } else {
            echo "Erro ao excluir!";
        }
        $stmt_excuir->close();
    } else {
        echo "Erro ao desassociar!" . $stmt_desassociar->error;
    }
    $stmt_desassociar->close();
}
function cadastrar_categoria($conexao, $nomeCategoria)
{
    $sql_verifica_categoria = "SELECT nomeCategoria from categoria WHERE nomeCategoria = ?";
    $stmt_verifica = $conexao->prepare($sql_verifica_categoria);
    $stmt_verifica->bind_param("s", $nomeCategoria);
    $stmt_verifica->execute();
    $resposta = $stmt_verifica->get_result();
    if ($resposta->num_rows > 0) {
        ?>
        <script>
            alert("Categoria já existe!")
            window.location.href = 'cadastro_categoria.php';
        </script>
        <?php
    } else {
        $sql_cadastro_categoria = "INSERT INTO categoria values (default,?)";
        $stmt_cadastro_categoria = $conexao->prepare($sql_cadastro_categoria);
        $stmt_cadastro_categoria->bind_param("s", $nomeCategoria);
        if ($stmt_cadastro_categoria->execute()) {
            header("location:cadastro_categoria.php");
        } else {
        ?>
            <script>
                alert("Erro ao cadastrar")
            </script>
        <?php
        }
        $stmt_verifica->close();
    }
    $stmt_cadastro_categoria->close();
}
function excluir_categoria($conexao, $id_categoria)
{
    $sql_desassociar = "UPDATE produtos set idCategoria = NULL WHERE idCategoria = ?";
    $stmt_desassociar = $conexao->prepare($sql_desassociar);
    $stmt_desassociar->bind_param("i", $id_categoria);
    if ($stmt_desassociar->execute()) {
        $sql_excluir = "DELETE FROM categoria WHERE idCategoria = ?";
        $stmt_excluir = $conexao->prepare($sql_excluir);
        $stmt_excluir->bind_param("i", $id_categoria);
        if ($stmt_excluir->execute()) {
        ?>
            <script>
                alert("Categoria excluída com sucesso!");
                window.location.href = "cadastro_categoria.php";
            </script>
    <?php
        } else {
            echo "ERRO ao excluir!";
        }
        $stmt_excluir->close();
    } else {
        echo "Erro ao desassociar!";
    }
    $stmt_desassociar->close();
}

function listar_categoria($conexao)
{
    $sql = "SELECT * FROM categoria";
    $resultado = $conexao->query($sql); ?>
    <select class="form-select  mb-3" name="idCategoria">
        <?php
        while ($linha = $resultado->fetch_array()) {
        ?>
            <option value="<?php echo $linha['idCategoria']; ?>"><?php echo $linha['nomeCategoria']; ?></option>
        <?php
        }
        ?>
    </select>
    <?php
}
function listar_produtos_total($conexao, $id_produto)
{
    $sql = "SELECT p.id, p.nome, p.quantidade, p.valor,p.imagem FROM produtos p
           INNER JOIN categoria c
           ON p.idCategoria = c.idCategoria
           WHERE c.idCategoria = ?";
    $stmt_categoria = $conexao->prepare($sql);
    $stmt_categoria->bind_param("s", $id_produto);
    $stmt_categoria->execute();
    $resultado = $stmt_categoria->get_result();
    if ($resultado->num_rows == 0) {
    ?>
        <div class="alert alert-primary" role="alert">
            Sem produtos
        </div>
    <?php
    }
    while ($linha = $resultado->fetch_array()) {
        $img = "../Upload/" . $linha['imagem'];
    ?>
        <div class="card card-imagem">
            <img src="<?php echo $img ?>" class="card-img-top img-produto" alt="<?php echo $linha['nome']; ?>">
            <form action="acoes.php" method="POST" onsubmit="return confirm('Deseja mesmo excluir?')">
                <input type="hidden" value="<?php echo $linha['id']; ?>" name="id">
                <button type="submit" class="fa-solid fa-x  btnExcluirProduto" name="btnExcluir"></button>
            </form>
            <div class="card-body">
                <h5 class="card-title"><?php echo $linha['nome']; ?></h5>
                <?php if ($linha['quantidade'] == 0) { ?>
                    <p class="card-text" style="color:#E5191A;">Quantidade atual: <?php echo $linha['quantidade']; ?></p>
                <?php } else { ?>
                    <p class="card-text">Quantidade atual: <?php echo $linha['quantidade']; ?></p>
                <?php } ?>
                <p class="card-text">Valor: R$<?php echo number_format($linha['valor'], 2, ',', '.'); ?></p>
                <form action="editar_estoque.php" method="POST">
                    <input type="hidden" value="<?php echo $linha['id']; ?>" name="id">
                    <button type="submit" class="botaoGeral btnEditar" name="btnEditar">Editar estoque</button>
                </form>
                <form action="editar_produto.php" method="POST">
                    <input type="hidden" value="<?php echo $linha['id']; ?>" name="id">
                    <button type="submit" class="botaoGeral btnEditar" name="btnEditar">Editar produto</button>
                </form>


            </div>
        </div>
    <?php
    }
}

function listar_produto($conexao, $id_produto)
{
    $sql = "SELECT nome, imagem,quantidade FROM produtos WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id_produto);
    $stmt->execute();
    $linha = $stmt->get_result()->fetch_array();
    $img = "../Upload/" . $linha['imagem'];
    ?>
    <div class="card">
        <img src="<?php echo $img; ?>" class="card-img-top img-produto-selecionado">
        <div class="card-body">
            <h5 class="card-title">Nome: <?php echo $linha['nome']; ?></h5>
            <p class="card-text">Quantidade atual: <?php echo $linha['quantidade']; ?> </p>
        </div>
    </div>
    <?php
    $stmt->close();
}
function gerenciar_estoque($conexao, $tipo, $qtd_movida, $id_produto)
{
    $sql_buscar = "SELECT quantidade from produtos WHERE id = ?";
    $stmt_buscar = $conexao->prepare($sql_buscar);
    $stmt_buscar->bind_param("i", $id_produto);
    $stmt_buscar->execute();
    $linha = $stmt_buscar->get_result()->fetch_array();
    $quantidade_atual = $linha['quantidade'];

    if ($tipo == 'entrada') {
        $sql_editar = "UPDATE produtos set quantidade = quantidade + ? WHERE id = ?";
    } else if ($tipo == 'saida' && $quantidade_atual >= $qtd_movida) {
        $sql_editar = "UPDATE produtos set quantidade = quantidade - ? WHERE id = ?";
    } else {
    ?>
        <script>
            alert("Estoque indisponível")
            window.location.href = "editar_estoque.php?id=<?php echo $id_produto; ?>"
        </script>
    <?php
    }
    $stmt_buscar->close();
    $stmt_editar = $conexao->prepare($sql_editar);
    $stmt_editar->bind_param("ii", $qtd_movida, $id_produto);
    if ($stmt_editar->execute()) {
    ?>
        <script>
            alert("Estoque alterado com sucesso!")
            window.location.href = "lista_produtos.php";
        </script>
        <?php
        $sql_inserir_movimentacao = "INSERT INTO movimentacao_estoque values (default,?,?,NOW(),?)";
        $stmt_inserir = $conexao->prepare($sql_inserir_movimentacao);
        $stmt_inserir->bind_param("sii", $tipo, $qtd_movida, $id_produto);
        if ($stmt_inserir->execute()) {
            echo "Movimentação registrada!";
        } else {
            echo "Erro!";
        }
    } else {
        echo "Erro ao atualizar o estoque!";
    }
    $stmt_editar->close();
}
function exibir_movimentacao($conexao)
{
    $sql = "SELECT m.tipo, m.qtd_movida, IF(m.idProduto IS NULL,'Excluído',p.nome) nome,m.data FROM movimentacao_estoque m LEFT JOIN produtos p ON
    m.idProduto = p.id";
    $resultado = $conexao->query($sql);
    if (!$resultado) {
        die("erro: " . $conexao->error());
    }
    while ($linha = $resultado->fetch_array()) {
        $data = new DateTime($linha['data']);
        ?>
        <tr>

            <td><?php echo $linha['nome']; ?></td>
            <td><?php echo ucfirst($linha['tipo']); ?></td>
            <td><?php echo $linha['qtd_movida']; ?></td>
            <td><?php echo $data->format("d/m/Y") . " às " . $data->format("H:i"); ?> </td>
        </tr>
        <?php
    }
}
function cadastrar_usuario($conexao, $nome, $usuario, $senha)
{
    $sql_verificar = "SELECT usuario FROM usuarios WHERE usuario = ?";
    $stmt_verifica = $conexao->prepare($sql_verificar);
    $stmt_verifica->bind_param("s", $usuario);
    if ($stmt_verifica->execute()) {
        $resultado = $stmt_verifica->get_result();
        if ($resultado->num_rows > 0) {
        ?>
            <script>
                alert("Usuário Indisponível");
                window.location.href = 'cadastro_usuarios.php';
            </script>
            <?php
        } else {
            $sql_cadastrar = "INSERT INTO usuarios VALUES (default,?,?,?)";
            $stmt_cadastrar = $conexao->prepare($sql_cadastrar);
            $stmt_cadastrar->bind_param("sss", $nome, $usuario, $senha);
            if ($stmt_cadastrar->execute()) {
            ?>
                <script>
                    alert("Cadastro feito com sucesso!");
                </script>
        <?php
            } else {
                echo "Erro ao cadastrar!";
            }
        }
    } else {
        echo "ERRO!";
    }
}
function editar_usuario($conexao, $nome, $usuario, $senha, $id_usuario)
{
    $sql_verificar = "SELECT usuario FROM usuarios WHERE usuario = ? AND idUsuario != ?";
    $stmt_verifica = $conexao->prepare($sql_verificar);
    $stmt_verifica->bind_param("si", $usuario, $id_usuario);
    $stmt_verifica->execute();
    $qtd_resultado = $stmt_verifica->get_result()->num_rows;
    if ($qtd_resultado > 0) {
        ?>
        <script>
            alert("Usuário já existe no banco de dados!")
            window.location.href = "editar_usuario.php";
        </script>
        <?php
    } else {
        $sql_editar = "UPDATE usuarios set nome = ?, usuario = ?, senha = ? WHERE idUsuario = ?";
        $stmt_editar = $conexao->prepare($sql_editar);
        $stmt_editar->bind_param("sssi", $nome, $usuario, $senha, $id_usuario);
        if ($stmt_editar->execute()) {
            $_SESSION['nome_usuario_logado'] = $nome;
        ?>
            <script>
                alert("Usuário alterado com sucesso!")
                window.location.href = "perfil.php";
            </script>
        <?php
        } else {
            echo "Erro " . $stmt_editar->error;
        }
        $stmt_editar->close();
    }
    $stmt_verifica->close();
}
function fazer_login($conexao, $usuario, $senha)
{
    $sql_logar = "SELECT * FROM usuarios WHERE usuario = ?  AND senha = ?";
    $stmt_logar = $conexao->prepare($sql_logar);
    $stmt_logar->bind_param("ss", $usuario, $senha);
    if ($stmt_logar->execute()) {
        $resultado = $stmt_logar->get_result();
        $linha = $resultado->fetch_array();
        if ($resultado->num_rows > 0) {
            $_SESSION['usuario_logado'] = $linha['idUsuario'];
            $_SESSION['nome_usuario_logado'] = $linha['nome'];

            header("location:escolha_categoria.php");
        } else {
        ?>
            <script>
                alert("Usuário e/ou senhas inválidos!")
                window.location.href = "login.php";
            </script>
        <?php
        }
    } else {
        echo "Erro!";
    }
}
function excluir_usuario($conexao, $id_usuario)
{
    $sql_excluir = "DELETE FROM usuarios WHERE idUsuario = ?";
    $stmt_excuir = $conexao->prepare($sql_excluir);
    $stmt_excuir->bind_param("i", $id_usuario);
    if ($stmt_excuir->execute()) {
        ?>
        <script>
            alert("Usuário excluído com sucesso!")
            window.location.href = "sair.php";
        </script>
    <?php
    }
}
function mostrar_nome($nome)
{
    echo "<h5> Olá, <strong>$nome</strong>! </h5>";
}
function formulario_acoes($link, $valor, $name, $mensagemBotao)
{
    ?>
    <form action="<?php echo $link . 'php'; ?>" method="POST">
        <input type="hidden" value="<?php echo $valor; ?>" name="<?php echo $valor; ?>">
        <button type="submit" class="btnEditarEstoque" name="<?php echo $name; ?>"><?php echo $mensagemBotao; ?></button>
    </form>
    <?php
}
function form_editar_usuario($conexao, $id_usuario)
{
    $sql = "SELECT * from usuarios WHERE idUsuario = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    if ($stmt->execute()) {
        $resultado = $stmt->get_result();
        $linha = $resultado->fetch_array();
    ?>
        <form action="acoes.php" method="POST">
            <div class="form-edicao-usuario">
                <label for="nome" class="form-label">Nome</label>
                <div class="mb-3">
                    <input type="text" class="form-control" name="nome" id="nome" value="<?php echo $linha['nome']; ?>">
                </div>
                <label for="usuario" class="form-label">Usuário</label>
                <div class="mb-3">
                    <input type="text" class="form-control" name="usuario" id="usuario" value="<?php echo $linha['usuario']; ?>">
                </div>
                <label for="senha" class="form-label">Senha</label>
                <div class="mb-3">
                    <input type="password" class="form-control" name="senha" id="senha" value="<?php echo $linha['senha']; ?>">
                </div>
                <div class="mb-3">
                    <a href="perfil.php"><button type="button" class="botao botaoCancelar"> Cancelar </button></a>
                    <input type="submit" class="botao botaoEnviar" value="Editar dados" name="editarUsuario">
                </div>
            </div>
        </form>
    <?php
    }
}
function exibir_dados_alteracao($conexao, $id_produto)
{
    $sql = "SELECT * FROM produtos WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id_produto);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $linha = $resultado->fetch_array();
    ?>
    <div class="cadastro-produto">
        <form action="acoes.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $linha['id']; ?>">
            </div>
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $linha['nome']; ?>">
            </div>
            <div class="mb-3">
                <label for="valor" class="form-label">Valor</label>
                <input type="text" class="form-control" id="valor" name="valor" value="<?php echo $linha['valor']; ?>">
            </div>
            <div class="mb-3">
                <label for="imagem" class="form-label">Imagem</label>
                <input type="file" class="form-control" id="imagem" name="imagem">
            </div>
            <div class="mb-3">
                <label class="form-label">Categoria</label>
                <?php listar_categoria($conexao); ?>
            </div>
            <div class="mb-3">
                <a href="lista_produtos.php"><button type="button" class="botao botaoCancelar"> Cancelar </button></a>
                <input type="submit" class="botao botaoEnviar" value="Enviar" name="editar_produtos" />
            </div>
        </form>
        </select>
    </div>
    </div>
<?php
}
function exibir_categoria_selecionada($conexao, $id_categoria)
{
    $sql = "SELECT nomeCategoria FROM categoria WHERE idCategoria = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id_categoria);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $linha = $resultado->fetch_array();
    return $linha['nomeCategoria'];
}
?>