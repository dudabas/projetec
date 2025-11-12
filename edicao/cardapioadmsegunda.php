<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/app/models/Carne.php';
require_once __DIR__ . '/app/models/Acompanhamento.php';
require_once __DIR__ . '/app/models/Salada.php';
require_once __DIR__ . '/app/models/CardapioImagem.php';
require_once __DIR__ . '/app/controllers/CardapioController.php';

$controller = new CardapioController();
$dia = "segunda-feira";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->salvar($dia);
    header("Location: cardapioadmsegunda.php?salvo=1");
    exit;
}

$dados = $controller->getDados($dia);

$carneLista = array_filter(array_map('trim', explode("\n", $dados['carne'])));
$acompLista = array_filter(array_map('trim', explode("\n", $dados['acomp'])));
$saladaLista = array_filter(array_map('trim', explode("\n", $dados['salada'])));
$imagem = $dados['imagem'] ?: "imagens/image.png";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Uai Menu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Quicksand&family=Architects+Daughter&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<header class="top-bar">
  <div class="icon-wrapper">
    <a href="../index.html">
      <img src="../imagens/image.png" alt="Logo" class="logo" />
    </a>
  </div>
  <nav class="menu">
    <div class="cardapio-dropdown">
      <a class="menulink" href="#" id="cardapio-link">Cardápio ▾</a>
      <div class="card-topbar" id="card-topbar" style="display: none;">
        <a href="cardapio.html" class="card-link">Ver cardápio do dia</a>
        <a href="../paginas_de_controle/cadastro_cliente.php" class="card-link">Receber diariamente</a>
        <a href="../paginas_de_controle/apagar_numero.php" class="card-link">Remover Número</a>
      </div>
    </div>
    <a class="menulink" href="../paginas_de_controle/cadastraradm.php">Administração</a>
    <a class="menulink" href="../paginas_de_controle/duvidas.html">Dúvidas</a>
  </nav>
</header>

<main class="container py-5">
  <h1 class="cardapiodia-page-title mb-4">Segunda-feira</h1>

  <?php if (isset($_GET['salvo'])): ?>
    <div class="alert alert-success text-center">Alterações salvas com sucesso!</div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data">

    <div class="text-center mb-4">
      <p class="lead fs-4 fw-semibold">Cardápio do dia:</p>
      <img src="<?= $imagem ?>" class="img-fluid rounded cardapiodia-img" style="max-width:400px" id="previewImg">
      <input type="file" name="imagem" accept="image/*" class="form-control mt-2" id="fileInput">
    </div>

    <div class="row g-4">
      <!-- Carnes -->
      <div class="col-md-4">
        <div class="card h-100 d-flex flex-column">
          <div class="card-header bg-danger text-white text-center fw-bold">Carnes</div>
          <div class="card-body d-flex flex-column">
            <ul class="list-unstyled">
              <?php foreach($carneLista as $item): ?>
                <li>- <?= htmlspecialchars($item) ?></li>
              <?php endforeach; ?>
            </ul>
            <textarea name="carne" class="form-control mt-2" style="display:none"></textarea>
            <button type="button" class="btn btn-uai btn-sm mt-auto editar-btn">Editar texto</button>
          </div>
        </div>
      </div>

      <!-- Acompanhamentos -->
      <div class="col-md-4">
        <div class="card h-100 d-flex flex-column">
          <div class="card-header bg-warning text-dark text-center fw-bold">Acompanhamentos</div>
          <div class="card-body d-flex flex-column">
            <ul class="list-unstyled">
              <?php foreach($acompLista as $item): ?>
                <li>- <?= htmlspecialchars($item) ?></li>
              <?php endforeach; ?>
            </ul>
            <textarea name="acompanhamento" class="form-control mt-2" style="display:none"></textarea>
            <button type="button" class="btn btn-uai btn-sm mt-auto editar-btn">Editar texto</button>
          </div>
        </div>
      </div>

      <!-- Saladas -->
      <div class="col-md-4">
        <div class="card h-100 d-flex flex-column">
          <div class="card-header bg-success text-white text-center fw-bold">Saladas</div>
          <div class="card-body d-flex flex-column">
            <ul class="list-unstyled">
              <?php foreach($saladaLista as $item): ?>
                <li>- <?= htmlspecialchars($item) ?></li>
              <?php endforeach; ?>
            </ul>
            <textarea name="salada" class="form-control mt-2" style="display:none"></textarea>
            <button type="button" class="btn btn-uai btn-sm mt-auto editar-btn">Editar texto</button>
          </div>
        </div>
      </div>
    </div>

    <div class="text-center mt-4">
      <button type="submit" class="btn btn-publicar">Publicar</button>
    </div>

    <div class="text-center mt-4">
        <button type="submit" class="btn btn-publicar" style="background-color: rgb(131, 182, 55)">Enviar para o WhatsApp  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
            <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
          </svg></button>
      </div>

  </form>
</main>

<footer class="bg-danger text-white text-center p-3 mt-5">
  Email de contato: Uaimenu@gmail.com
</footer>

<script>
document.querySelectorAll('.editar-btn').forEach(btn => {
  btn.onclick = () => {
    let card = btn.closest('.card-body');
    card.querySelector('ul').style.display = 'none';
    let textarea = card.querySelector('textarea');
    textarea.style.display = 'block';
    textarea.value = [...card.querySelectorAll('li')].map(li=>li.innerText.replace('- ','')).join("\n");
  }
});

document.getElementById('fileInput').onchange = e => {
  let reader = new FileReader();
  reader.onload = ev => document.getElementById('previewImg').src = ev.target.result;
  reader.readAsDataURL(e.target.files[0]);
};
</script>

</body>
</html>


