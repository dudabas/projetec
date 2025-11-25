<?php require '../config.php';
require INC_PATH . '/header.php';
session_start(); // Inicia a sessão para acessar $_SESSION
?>
<!DOCTYPE html>
<html lang="pt-BR">
  <head>

  <meta charset="UTF-8" />

  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Uai Menu</title>

  <!-- Bootstrap CSS -->

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="../styles.css" />

  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600&family=Architects+Daughter&family=Tangerine:wght@700&display=swap" rel="stylesheet">

</head>
<body>
<main class="container my-5">
    <div class="row align-items-center">
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="image-container-cadastrar">
                <img src="../imagens/espaguete.png" alt="Imagem de Comida Mineira" class="img-fluid rounded shadow" />
            </div>
        </div>
        <div class="col-md-6" >
        <div class="card shadow p-4" id="card-formulario">
            <h2 class="card-title mb-4" id="titulo-cadastro">Cadastro de Usuário</h2>
            
            <?php 
            // 🛑 BLOCO DE TRATAMENTO DE ERROS 🛑
            if (isset($_SESSION['erro'])) {
                echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($_SESSION['erro']) . '</div>';
                unset($_SESSION['erro']); // Limpa a mensagem após exibir
            }
            ?>
            
            <form action="cadastraradmphp.php" method="POST">
            <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="seuemail@exemplo.com" required>
                </div>
            
                <div class="mb-3">
                    <label for="senha" class="form-label fw-semibold">Senha:</label>
                    <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha" required>
                </div>
            
                <ul>
                    <li>Mínimo 8 caracteres</li>
                    <li>Conter caracteres especiais</li>
                    <li>Conter números e letras</li>
                </ul>
            
                <div class="mb-3">
                    <label for="confirmarSenha" class="form-label fw-semibold">Confirmar senha:</label>
                    <input type="password" class="form-control" id="confirmarSenha" name="confirmarSenha" placeholder="Confirme sua senha" required>
                </div>
            
                <div class="mb-3">
                    <label for="senhaAdm" class="form-label fw-semibold">Senha Administrativa:</label>
                    <input type="password" class="form-control" id="senhaAdm" name="senhaAdm" placeholder="Digite a senha para administradores">
                </div>
            
                <button type="submit" class="btn btn-primary w-100" id="botao-cadastro">Enviar</button>
          </form>
            
        </div>
    </div>
</div>
</main>
<footer>
    Email de contato: Uaimenu@gmail.com
  </footer>
   <!--animaçao do rodapé -->
<script>
  let lastScrollTop = 0;
  const footer = document.querySelector("footer");

  window.addEventListener("scroll", function () {
    let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    if (scrollTop > lastScrollTop) {
      // Scrolling down
      footer.style.animation = "none"; // Reset animation
      void footer.offsetHeight; // Trigger reflow
      footer.style.animation = "floatIn 0.8s ease-out forwards"; // Restart animation
    }

    lastScrollTop = scrollTop <= 0 ? 0 : scrollTop; // Avoid negative values
  });

//fazer o a caixa branca aparece
  const link = document.getElementById("cardapio-link");
  const cardTopbar = document.getElementById("card-topbar");

  link.addEventListener("click", function (e) {
    e.preventDefault();
    cardTopbar.style.display =
      cardTopbar.style.display === "block" ? "none" : "block";
      
  });
  
</script>
</body>
</html>
