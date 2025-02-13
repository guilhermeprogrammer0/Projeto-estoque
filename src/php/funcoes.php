<?php
session_start();
function cadastrar_produto($conexao,$nome,$quantidade,$valor,$imagem,$idCategoria){
    $arquivo = $_FILES['imagem'];
    $nomeImagem = $arquivo['name'];
    $tmp_name = $arquivo['tmp_name'];
    $extensao = pathinfo($nomeImagem, PATHINFO_EXTENSION);
    $novo_nome = uniqid() . "." .$extensao;
    move_uploaded_file($tmp_name,'../Upload/'.$novo_nome);
    $sql_cadastrar = "INSERT INTO produtos VALUES (default,?,?,?,?,?)";
    $stmt_cadastrar = $conexao->prepare($sql_cadastrar);
    $stmt_cadastrar->bind_param("sidsi",$nome,$quantidade,$valor,$novo_nome,$idCategoria);
    if($stmt_cadastrar->execute()){
        ?>
            <script>alert("Produto cadastrado com sucesso");</script>
        <?php
    }
   
    $stmt_cadastrar->close();
}
function excluir_produto($conexao,$id_produto){
    $sql_desassociar = "UPDATE movimentacao_estoque set idProduto = NULL WHERE idProduto = ?";
    $stmt_desassociar = $conexao->prepare($sql_desassociar);
    $stmt_desassociar->bind_param("i",$id_produto);
    if($stmt_desassociar->execute()){
        $sql_excluir = "DELETE FROM produtos WHERE id = ?";
        $stmt_excuir = $conexao->prepare($sql_excluir);
        $stmt_excuir->bind_param("i",$id_produto);
        if($stmt_excuir->execute()){
            ?>
            <script>alert("Produto excluído com sucesso!")
                window.location.href = "lista_produtos.php";
            </script>
            <?php
        }
        else{
            echo "Erro ao excluir!";
        }
        $stmt_excuir->close();
    }
    else{
        echo "Erro ao desassociar!" . $stmt_desassociar->error;
    }
    $stmt_desassociar->close();
}
function cadastrar_categoria($conexao,$nomeCategoria){
    $sql_verifica_categoria = "SELECT nomeCategoria from categoria WHERE nomeCategoria = ?";
    $stmt_verifica = $conexao->prepare($sql_verifica_categoria);
    $stmt_verifica->bind_param("s",$nomeCategoria);
    $stmt_verifica->execute();
    $resposta = $stmt_verifica->get_result();
    if($resposta->num_rows>0){
        echo "Categoria já existente!";
    }
    else{
        $sql_cadastro_categoria = "INSERT INTO categoria values (default,?)";
        $stmt_cadastro_categoria = $conexao->prepare($sql_cadastro_categoria);
        $stmt_cadastro_categoria->bind_param("s",$nomeCategoria);
        if($stmt_cadastro_categoria->execute()){
            ?>
        <script>alert("Categoria cadastrada com sucesso!")</script>
        <?php
        }
        else{
            ?>
            <script>alert("Erro ao cadastrar")</script>
            <?php
        }
        $stmt_verifica->close();
    }
    $stmt_cadastro_categoria->close();
}
function listar_categoria($conexao){
    $sql = "SELECT * FROM categoria";
    $resultado = $conexao->query($sql);?>
    <select class="form-select  mb-3" name="idCategoria">
    <?php
    while($linha = $resultado->fetch_array())
    {
    ?>
                <option value="<?php echo $linha['idCategoria'];?>"><?php  echo $linha['nomeCategoria'];?></option>
                <?php
    }
    ?>
            </select>
            <?php
    
}
function listar_produtos_total($conexao,$id_produto){
    $sql = "SELECT p.id, p.nome, p.quantidade, p.valor,p.imagem FROM produtos p
           INNER JOIN categoria c
           ON p.idCategoria = c.idCategoria
           WHERE c.idCategoria = ?";
           $stmt_categoria = $conexao->prepare($sql);
           $stmt_categoria->bind_param("s",$id_produto);
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
                <i class="fa-solid fa-x  btnExcluirProduto" onclick="excluirProduto(<?php echo $linha['id'];?>)"></i>
                <div class="card-body">
                 <h5 class="card-title">Nome: <?php echo $linha['nome'];?></h5>
                <p class="card-text">Quantidade atual: <?php echo $linha['quantidade'];?></p>
                <p class="card-text">Valor: R$<?php echo number_format($linha['valor'],2,',','.');?></p>
                <button class="btnEditarEstoque" onclick="editarEstoque(<?php echo $linha['id'];?>)">Editar estoque </button>
  </div>
</div>
            <?php
}
}      

function listar_produto($conexao,$id_produto){
    $sql = "SELECT nome, imagem,quantidade FROM produtos WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i",$id_produto);
    $stmt->execute();
    $linha = $stmt->get_result()->fetch_array();
    $img = "../Upload/" . $linha['imagem'];
    ?>
    <div class="card" >
  <img src="<?php echo $img;?>" class="card-img-top img-produto-selecionado">
  <div class="card-body">
    <h5 class="card-title">Nome: <?php echo $linha['nome'];?></h5>
    <p class="card-text">Quantidade atual: <?php echo $linha['quantidade'];?> </p>
  </div>
</div>
    <?php
    $stmt->close();
}
function gerenciar_estoque($conexao,$tipo,$qtd_movida,$id_produto){
    $sql_buscar = "SELECT quantidade from produtos WHERE id = ?";
    $stmt_buscar = $conexao->prepare($sql_buscar);
    $stmt_buscar->bind_param("i",$id_produto);
    $stmt_buscar->execute();
    $linha = $stmt_buscar->get_result()->fetch_array();
    $quantidade_atual = $linha['quantidade'];

    if($tipo == 'entrada'){
        $sql_editar = "UPDATE produtos set quantidade = quantidade + ? WHERE id = ?";
    }
    else if($tipo == 'saida' && $quantidade_atual>=$qtd_movida){
        $sql_editar = "UPDATE produtos set quantidade = quantidade - ? WHERE id = ?";
    }
    else{
        ?>
        <script>alert("Estoque indisponível")
            window.location.href = "editar_estoque.php?id=<?php echo $id_produto;?>"
        </script>
        <?php
    }
    $stmt_buscar->close();
    $stmt_editar = $conexao->prepare($sql_editar);
    $stmt_editar->bind_param("ii",$qtd_movida,$id_produto);
    if($stmt_editar->execute()){
        ?>
        <script>alert("Estoque alterado com sucesso!")
            window.location.href = "lista_produtos.php";
        </script>
        <?php
        $sql_inserir_movimentacao = "INSERT INTO movimentacao_estoque values (default,?,?,NOW(),?)";
        $stmt_inserir = $conexao->prepare($sql_inserir_movimentacao);
        $stmt_inserir->bind_param("sii",$tipo,$qtd_movida,$id_produto);
        if($stmt_inserir->execute()){
            echo "Movimentação registrada!";
        }
        else{
            echo "Erro!";
        }
    }
    else{
        echo "Erro ao atualizar o estoque!";
    }
    $stmt_editar->close();
}
function exibir_escolha_categoria($conexao,$tipo){
    if($tipo=='categoria'){
        ?>
        <div class="mb-3 cadastrar-categoria">
                <label for="nomeCategoria" class="form-label categoria">Nome Categoria</label>
                <input type="text" class="form-control" id="nomeCategoria" name="nomeCategoria" required>
        </div>
        <?php
    }
    else if($tipo=='produtos'){
        ?>
                <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
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
                <label  class="form-label">Categoria</label>
                <?php listar_categoria($conexao);?>
                </div>
                <?php
    }
}
function exibir_movimentacao($conexao){
    $sql = "SELECT m.tipo, m.qtd_movida, IF(m.idProduto IS NULL,'Excluído',p.nome) nome,m.data FROM movimentacao_estoque m LEFT JOIN produtos p ON
    m.idProduto = p.id";
    $resultado = $conexao->query($sql);
    if(!$resultado){
        die("erro: " . $conexao->error());
    }
    while($linha = $resultado->fetch_array()){
    $data = new DateTime($linha['data']);
    ?>
    <tr>
    
      <td><?php echo $linha['nome'];?></td>
      <td><?php echo ucfirst($linha['tipo']);?></td>
      <td><?php echo $linha['qtd_movida'];?></td>
      <td><?php echo $data->format("d/m/Y");?></td>
    </tr>
<?php
}
}
function cadastrar_usuario($conexao,$nome,$usuario,$senha){
    $sql_verificar = "SELECT usuario FROM usuarios WHERE usuario = ?";
    $stmt_verifica = $conexao->prepare($sql_verificar);
    $stmt_verifica->bind_param("s",$usuario);
    if($stmt_verifica->execute()){
        $resultado = $stmt_verifica->get_result();
        if($resultado->num_rows>0){
            ?>
            <script>alert("Usuário Indisponível");
                window.location.href = 'cadastro_usuarios.php';
            </script>
            <?php
        }
        else{
            $sql_cadastrar = "INSERT INTO usuarios VALUES (default,?,?,?)";
            $stmt_cadastrar = $conexao->prepare($sql_cadastrar);
            $stmt_cadastrar->bind_param("sss",$nome,$usuario,$senha);
            if($stmt_cadastrar->execute()){
                ?>
            <script>alert("Cadastro feito com sucesso!");
                window.location.href = 'login.php';
            </script>
            <?php
            }
            else{
                echo "Erro ao cadastrar!";
            }
        }
    }
    else{
        echo "ERRO!";
    }
}
function fazer_login($conexao,$usuario,$senha){
    $sql_logar = "SELECT * FROM usuarios WHERE usuario = ?  AND senha = ?";
    $stmt_logar = $conexao->prepare($sql_logar);
    $stmt_logar->bind_param("ss",$usuario,$senha);
    if($stmt_logar->execute()){
        $resultado = $stmt_logar->get_result();
        $linha = $resultado->fetch_array();
        if($resultado->num_rows>0){
            $_SESSION['usuario_logado'] = $linha['idUsuario'];
            $_SESSION['nome_usuario_logado'] = $linha['nome'];

            header("location:escolha_categoria.php");
        }
        else{
            ?>
            <script>alert("Usuário e/ou senhas inválidos!")
                window.location.href = "login.php";
            </script>
            <?php
        }
    }
    else{
        echo "Erro!";
    }
}
function mostrar_nome($nome){
    echo "<h5> Olá, <strong>$nome</strong>! </h5>";
}

?>