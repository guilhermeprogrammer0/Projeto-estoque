<?php
require_once "funcoes.php";
require_once "conexao.php";
require_once "verificacao_login.php";
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Meu perfil</title>
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
    <div class="area-exibicao">
      <div class="meu-perfil">
        <div class="card text-center">
          <div class="card-header">
            Dados
          </div>
          <div class="card-body">
            <h2 class="card-title"> Funcionário: <?php echo $_SESSION['nome_usuario_logado']; ?> </h2>
            <a href="editar_usuario.php"><button type="button" class="botaoGeral btnEditar" name="btnEditar">Editar dados</button></a>
            <form action="acoes.php" method="POST" onsubmit="return confirm('Deseja mesmo excluir sua conta?')">
              <input type="hidden" name="idUsuario" value="<?php echo $_SESSION['usuario_logado']; ?>">
              <button type="submit" class="botaoGeral btnExcluirConta" name="btnexcluirUsuario">Excluir conta</button>
            </form>


          </div>
          <div class="card-footer text-muted">
            Lembre - se de seguir as normas para alterar os seus dados
          </div>
        </div>
      </div>
  </main>

</body>

</html>