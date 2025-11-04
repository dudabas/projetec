<?php
require_once 'config/database.php';
require_once 'app/models/Carne.php';
require_once 'app/models/Acompanhamento.php';
require_once 'app/models/Salada.php';

$dia = 'segunda-feira'; 
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $carne = $_POST['carne'] ?? '';
    $acomp = $_POST['acompanhamento'] ?? '';
    $salada = $_POST['salada'] ?? '';

    $ok1 = Carne::atualizar($dia, $carne);
    $ok2 = Acompanhamento::atualizar($dia, $acomp);
    $ok3 = Salada::atualizar($dia, $salada);

    $msg = ($ok1 && $ok2 && $ok3) ? "Alterações salvas com sucesso!" : "Erro ao salvar alterações!";
}

$carneAtual = Carne::buscar($dia);
$acompAtual = Acompanhamento::buscar($dia);
$saladaAtual = Salada::buscar($dia);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Uai Menu - Administração (<?= ucfirst($dia) ?>)</title>
  <link rel="stylesheet" href="styles.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <header class="top-bar">
    <div class="icon-wrapper">
      <img src="imagens/image.png" alt="Logo" class="logo" />
    </div>
    <nav class="menu">
      <a class="menulink" href="#">Cardápio ▾</a>
      <a class="menulink" href="#">Administração</a>
    </nav>
  </header>

  <main class="container py-5">
    <h1 class="cardapiodia-page-title mb-4">Cardápio de <?= ucfirst($dia) ?></h1>

    <?php if ($msg): ?>
      <div class="alert alert-info text-center"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <form method="POST" class="text-center">
      <div class="row g-4 justify-content-center">

        <!-- Carnes -->
        <div class="col-md-3">
          <div class="card h-100 border-danger">
            <div class="card-header bg-danger text-white text-center fw-bold">Carnes</div>
            <div class="card-body">
              <textarea name="carne" class="form-control" rows="5"><?= htmlspecialchars($carneAtual) ?></textarea>
            </div>
          </div>
        </div>

        <!-- Acompanhamentos -->
        <div class="col-md-3">
          <div class="card h-100 border-warning">
            <div class="card-header bg-warning text-dark text-center fw-bold">Acompanhamentos</div>
            <div class="card-body">
              <textarea name="acompanhamento" class="form-control" rows="5"><?= htmlspecialchars($acompAtual) ?></textarea>
            </div>
          </div>
        </div>

        <!-- Saladas -->
        <div class="col-md-3">
          <div class="card h-100 border-success">
            <div class="card-header bg-success text-white text-center fw-bold">Saladas</div>
            <div class="card-body">
              <textarea name="salada" class="form-control" rows="5"><?= htmlspecialchars($saladaAtual) ?></textarea>
            </div>
          </div>
        </div>

      </div>

      <div class="text-center mt-4">
        <button type="submit" class="btn btn-publicar">Salvar Alterações</button>
      </div>
    </form>
  </main>

  <footer class="bg-danger text-white text-center p-3 mt-5">
    Email de contato: Uaimenu@gmail.com
  </footer>
</body>
</html>
