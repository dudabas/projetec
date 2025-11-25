<?php
require_once __DIR__ . '/../edicao/config/database.php';

$conn = Database::conectar();
$dia = "segunda-feira";

function buscarTexto($conn, $tabela, $campo, $dia) {
  $sql = $conn->prepare("SELECT $campo FROM $tabela WHERE dia = :dia LIMIT 1");
  $sql->bindParam(':dia', $dia);
  $sql->execute();
  $texto = $sql->fetchColumn();
  return $texto ? array_filter(array_map('trim', explode("\n", $texto))) : [];
}

$carne_items = buscarTexto($conn, "carne", "carne", $dia);
$acomp_items = buscarTexto($conn, "acompanhamento", "acompanhamento", $dia);
$salada_items = buscarTexto($conn, "salada", "salada", $dia);

// imagem
$img = $conn->prepare("SELECT imagem FROM cardapio_dia WHERE dia = :dia LIMIT 1");
$img->bindParam(':dia', $dia);
$img->execute();
$imagem = $img->fetchColumn();

// caminho final
$imagemExibida = $imagem ? "../edicao/" . $imagem : "../imagens/comida.png";
?>
<?php 
require __DIR__ . '/../config.php';
require INC_PATH . '/header.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Uai Menu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Quicksand&family=Architects+Daughter&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../styles.css">
</head>
<body>


  <main class="container py-5">
  <h1 class="cardapiodia-page-title mb-4">Segunda-feira</h1>

  <div class="cardapiodia-page-item">
    <div class="text-center mb-4">
      <p class="lead fs-4 fw-semibold">Cardápio do dia:</p>

      <!-- IMAGEM DO BANCO -->
      <img src="<?= $imagemExibida ?>" alt="Prato do dia" class="img-fluid rounded cardapiodia-img" style="max-width:400px; max-height:300px; object-fit:cover;">
    </div>

    <div class="row g-4">
      <div class="col-md-4">
        <div class="card h-100">
          <div class="card-header bg-danger text-white text-center fw-bold">Carnes</div>
          <div class="card-body">
            <ul class="list-unstyled">
              <?php if (!empty($carne_items)): ?>
                <?php foreach ($carne_items as $item): ?>
                  <li>- <?= htmlspecialchars($item) ?></li>
                <?php endforeach; ?>
              <?php else: ?>
                <li>- Em breve</li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card h-100">
          <div class="card-header bg-warning text-dark text-center fw-bold">Acompanhamentos</div>
          <div class="card-body">
            <ul class="list-unstyled">
              <?php if (!empty($acomp_items)): ?>
                <?php foreach ($acomp_items as $item): ?>
                  <li>- <?= htmlspecialchars($item) ?></li>
                <?php endforeach; ?>
              <?php else: ?>
                <li>- Em breve</li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card h-100">
          <div class="card-header bg-success text-white text-center fw-bold">Salada</div>
          <div class="card-body">
            <ul class="list-unstyled">
              <?php if (!empty($salada_items)): ?>
                <?php foreach ($salada_items as $item): ?>
                  <li>- <?= htmlspecialchars($item) ?></li>
                <?php endforeach; ?>
              <?php else: ?>
                <li>- Em breve</li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

  <footer class="bg-danger text-white text-center p-3 mt-5">
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

