function editarEstoque(id){
    window.location.href = `editar_estoque.php?id=${id}`;
}
function excluirProduto(id){
    let confirmar = confirm("Deseja mesmo excluir?");
    confirmar === true? window.location.href = `excluir_produto.php?id_produto_excluir=${id}`: console.log("Não excluiu!");
}