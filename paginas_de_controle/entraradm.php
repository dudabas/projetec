
<?php require '../config.php';
require INC_PATH . '/header.php';
session_start(); // Inicia a sessão

// 🚨 Checa se o admin já está logado e redireciona automaticamente
if (isset($_SESSION['admin_logado']) && $_SESSION['admin_logado'] === true) {
    header("Location: cardapioadm.php"); // Redireciona para o painel
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Uai Menu - Login</title>
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
                <h2 class="card-title mb-4" id="titulo-cadastro" >Vamos entrar!</h2>
                
                <?php if (isset($_SESSION['erro'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $_SESSION['erro']; unset($_SESSION['erro']); ?>
                    </div>
                <?php endif; ?>
                
                <!-- Ação correta: enviando para login.php -->
                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold" id="label_entrar">Email:</label>
                        
                        <input type="email" class="form-control" id="email" name="email" placeholder="seuemail@exemplo.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label fw-semibold" id="label_entrar">Senha:</label>
                
                        <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha" required>
                    </div>
                    <div class="mb-3" id="link-entrar-container">
                        <a href="cadastraradm.php" class="card-link d-block">Criar conta</a>
                      </div>
                    <button type="submit" class="btn btn-primary w-100" id="botao-cadastro">Entrar</button>
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
