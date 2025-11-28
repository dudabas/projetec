<?php 
require '../config.php';
require INC_PATH . '/header.php';
// Inclui o arquivo de conexão. CORRIJA O CAMINHO SE NECESSÁRIO!
require 'cadastro_clientephp.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$mensagem = '';
$mensagem_sucesso = '';
$nome_pagina = basename(__FILE__); // Obtém 'apagar_numero.php'

// 1. Lógica para remover um número do banco de dados
if (isset($_GET['id_remover']) && is_numeric($_GET['id_remover'])) {
    $id_cliente = (int)$_GET['id_remover'];
    
    try {
        $stmt_delete = $pdo->prepare("DELETE FROM cliente_rest WHERE id_cliente_rest = ?");
        $stmt_delete->execute([$id_cliente]);
        
        if ($stmt_delete->rowCount() > 0) {
            // Redireciona para a própria página com mensagem de sucesso
            header("Location: {$nome_pagina}?sucesso=removido");
            exit;
        } else {
            $mensagem = 'Erro: Cliente não encontrado ou já removido.';
        }
        
    } catch (PDOException $e) {
        $mensagem = 'Erro ao remover: ' . $e->getMessage();
    }
}

// 2. Mensagem de feedback após a remoção (após o redirecionamento)
if (isset($_GET['sucesso']) && $_GET['sucesso'] === 'removido') {
    $mensagem_sucesso = 'Número removido com sucesso!';
}

// 3. Lógica para buscar todos os números cadastrados
$numeros_cadastrados = [];
try {
    $stmt_select = $pdo->query("SELECT id_cliente_rest, telefone, nome FROM cliente_rest ORDER BY id_cliente_rest DESC");
    $numeros_cadastrados = $stmt_select->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $mensagem = 'Erro ao carregar números: ' . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Uai Menu - Apagar Números</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css" />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600&family=Architects+Daughter&family=Tangerine:wght@700&display=swap" rel="stylesheet">
</head>

<body>

<main class="container my-5">
    <div class="row align-items-center">
        <div class="col-md-6 mb-4 mb-md-0 ">
            <div class="image-container-cadastrar">
                <img src="<?php echo $BASE_PATH; ?>/imagens/espaguete.png" alt="Imagem de Comida Mineira" class="img-fluid rounded shadow" />
            </div>
        </div>
        
        <div class="col-md-6" >
            <div class="card shadow p-4 cadastros" >
                <h2 class="card-title mb-4 text-center" id="titulo-cadastro" >Gerenciar Números</h2>
                
                <?php if ($mensagem_sucesso): ?>
                    <div class="alert alert-success text-center" role="alert">
                        <?php echo $mensagem_sucesso; ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($mensagem): ?>
                    <div class="alert alert-danger text-center" role="alert">
                        <?php echo $mensagem; ?>
                    </div>
                <?php endif; ?>
                
                <?php if (empty($numeros_cadastrados)): ?>
                    <div class="alert alert-info text-center" role="alert">
                        Nenhum número cadastrado no banco de dados.
                    </div>
                <?php else: ?>
                    <p class="fs-5 fw-semibold text-center">Números Cadastrados (Total: <?php echo count($numeros_cadastrados); ?>)</p>
                    
                    <ul class="list-group">
                        <?php foreach ($numeros_cadastrados as $cliente): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <?php echo htmlspecialchars(!empty($cliente['nome']) ? $cliente['nome'] : 'ID ' . $cliente['id_cliente_rest']); ?>
                                    <br>
                                    <strong>Tel:</strong> <?php echo htmlspecialchars($cliente['telefone']); ?>
                                </div>
                                
                                <a href="<?php echo $nome_pagina; ?>?id_remover=<?php echo $cliente['id_cliente_rest']; ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('ATENÇÃO! Tem certeza que deseja remover o número <?php echo htmlspecialchars($cliente['telefone']); ?>? Esta ação não pode ser desfeita.')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                      <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                      <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>
                                    Remover
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    
                <?php endif; ?>

            </div>
        </div>
    </div>
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
            footer.style.animation = "none";
            void footer.offsetHeight;
            footer.style.animation = "floatIn 0.8s ease-out forwards";
        }
        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    });

    const link = document.getElementById("cardapio-link");
    const cardTopbar = document.getElementById("card-topbar");

    if(link && cardTopbar) { 
        link.addEventListener("click", function (e) {
            e.preventDefault();
            cardTopbar.style.display =
                cardTopbar.style.display === "block" ? "none" : "block";
        });
    }
</script>
</body>

</html>
