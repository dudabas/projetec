<?php require '../config.php';
require INC_PATH . '/header.php';?>
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
        <!-- Coluna da Imagem -->
        <div class="col-md-6 mb-4 mb-md-0 ">
            <div class="image-container-cadastrar">
                <img src="<?php echo $BASE_PATH; ?>/imagens/espaguete.png" alt="Imagem de Comida Mineira" class="img-fluid rounded shadow" />
            </div>
        </div>
        <!-- Coluna do Formulário -->
    <div class="col-md-6" >
        <div class="card shadow p-4 cadastros" >
            <h2 class="card-title mb-4" id="titulo-cadastro" >Remover número</h2>
            <form>
                <!-- Numero -->
                <div class="mb-3">
                    <p class="fs-5 fw-semibold text-center">Digite seu número do Whatsapp</p>
                    <input type="tel" class="form-control" id="Numero" placeholder="(xx) xxxxx-xxxx" required>

                </div>
                <!-- Botao apagar -->
                <a href="<?php echo $BASE_PATH; ?>index.php" type="submit" class="btn btn-primary w-100" id="botao-cadastro">Apagar</a>
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







