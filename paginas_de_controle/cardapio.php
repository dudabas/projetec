<?php 
require_once __DIR__ . '/../edicao/config/database.php';
require '../includes/header.php';

// Conexão
$conn = Database::conectar();

// Função para buscar imagem no banco
function buscarImagem($conn, $dia) {
    $query = $conn->prepare("SELECT imagem FROM cardapio_dia WHERE dia = :dia LIMIT 1");
    $query->bindParam(':dia', $dia);
    $query->execute();
    $img = $query->fetchColumn();

    if ($img) {
        return "../edicao/" . $img;
    }

    return "../imagens/comida.png";
}

// Carregar imagens de cada dia
$img_seg = buscarImagem($conn, "segunda-feira");
$img_ter = buscarImagem($conn, "terça-feira");
$img_qua = buscarImagem($conn, "quarta-feira");
$img_qui = buscarImagem($conn, "quinta-feira");
$img_sex = buscarImagem($conn, "sexta-feira");
$img_sab = buscarImagem($conn, "sábado");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Uai Menu</title>
  <link href="https://fonts.googleapis.com/css2?family=Quicksand&family=Architects+Daughter&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../styles.css">
</head>
<body>

<main class="container my-4">
  <section class="row g-4">

      <!-- Segunda-feira -->
  <div class="col-md-6 col-lg-4">
    <div class="card h-100" id="dia">
      <img src="<?= $img_seg ?>" class="card-img-top" alt="Segunda-feira" style="height:200px; object-fit:cover;">
      <div class="card-body">
        <h5 class="card-title">Segunda-feira</h5>
        <a href="../dias_da_semana/cardapiosegunda.php" class="btn btn-primary">Clique para acessar </a>
      </div>
    </div>
  </div>

  <!-- Terça-feira -->
  <div class="col-md-6 col-lg-4">
    <div class="card h-100" id="dia">
      <img src="<?= $img_ter ?>" class="card-img-top" alt="Terça-feira" style="height:200px; object-fit:cover;">
      <div class="card-body">
        <h5 class="card-title">Terça-feira</h5>
        <a href="../dias_da_semana/cardapioterca.php" class="btn btn-primary">Clique para acessar </a>
      </div>
    </div>
  </div>

  <!-- Quarta-feira -->
  <div class="col-md-6 col-lg-4">
    <div class="card h-100" id="dia">
      <img src="<?= $img_qua ?>" class="card-img-top" alt="Quarta-feira" style="height:200px; object-fit:cover;">
      <div class="card-body">
        <h5 class="card-title">Quarta-feira</h5>
        <a href="../dias_da_semana/cardapioquarta.php" class="btn btn-primary">Clique para acessar </a>
      </div>
    </div>
  </div>

  <!-- Quinta-feira -->
  <div class="col-md-6 col-lg-4">
    <div class="card h-100" id="dia">
      <img src="<?= $img_qui ?>" class="card-img-top" alt="Quinta-feira" style="height:200px; object-fit:cover;">
      <div class="card-body">
        <h5 class="card-title">Quinta-feira</h5>
        <a href="../dias_da_semana/cardapioquinta.php" class="btn btn-primary">Clique para acessar </a>
      </div>
    </div>
  </div>

  <!-- Sexta-feira -->
  <div class="col-md-6 col-lg-4">
    <div class="card h-100" id="dia">
      <img src="<?= $img_sex ?>" class="card-img-top" alt="Sexta-feira" style="height:200px; object-fit:cover;">
      <div class="card-body">
        <h5 class="card-title">Sexta-feira</h5>
        <a href="../dias_da_semana/cardapiosexta.php" class="btn btn-primary">Clique para acessar </a>
      </div>
    </div>
  </div>

  <!-- Sábado -->
  <div class="col-md-6 col-lg-4">
    <div class="card h-100" id="dia">
      <img src="<?= $img_sab ?>" class="card-img-top" alt="Sábado" style="height:200px; object-fit:cover;">
      <div class="card-body">
        <h5 class="card-title">Sábado</h5>
        <a href="../dias_da_semana/cardapiosabado.php" class="btn btn-primary">Clique para acessar </a>
      </div>
    </div>
  </div>

  </section>
</main>

<footer>
  Email de contato: Uaimenu@gmail.com
</footer>

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

