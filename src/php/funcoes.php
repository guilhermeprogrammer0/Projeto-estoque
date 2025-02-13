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
}
function listar_categoria($conexao){
    $sql = "SELECT * FROM categoria";
    $resultado = $conexao->query($sql);
    while($linha = $resultado->fetch_array())
    {
    ?>
    <div class="form-check">
    <input class="form-check-input" type="radio" name="idCategoria" value="<?php echo $linha['idCategoria'];?>">
    <label class="form-check-label"><?php echo $linha['nomeCategoria'];?></label>
    </div>
    <?php
    }
}
function listar_produto($conexao,$id_produto){
    $sql = "SELECT nome, imagem FROM produtos WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i",$id_produto);
    $stmt->execute();
    $linha = $stmt->get_result()->fetch_array();
    $img = "../Upload/" . $linha['imagem'];
    ?>
        <div class="card card-gerenciado">
            <p><img src="<?php echo $img;?>"> </p>
            <div class="card-body">
         <h5>Nome: <?php echo $linha['nome'];?></h5>
        </div>
    </div>
    <?php
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
        <script>alert("Estoque indisponível")</script>
        <?php
    }
    $stmt_editar = $conexao->prepare($sql_editar);
    $stmt_editar->bind_param("ii",$qtd_movida,$id_produto);
    if($stmt_editar->execute()){
        ?>
        <script>alert("Estoque alterado com sucesso!")</script>
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

    
    
}
?>