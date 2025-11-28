﻿<?php 
require '../config.php';
require INC_PATH . '/header.php';
// Inclui o arquivo de conexão. CORRIJA O CAMINHO SE NECESSÁRIO!
require 'cadastro_clientephp.php'; 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$mensagem = '';

// Processar o formulário quando enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Numero'])) {
    $novo_numero = trim($_POST['Numero']);
    
    // PHP: Remover caracteres não numéricos para salvar o número limpo no DB
    $numero_limpo = preg_replace('/\D/', '', $novo_numero); 

    // Validação básica: verificar se tem entre 10 (DD+8) e 11 dígitos (DD+9)
    if (strlen($numero_limpo) >= 10 && strlen($numero_limpo) <= 11) {
        
        try {
            // 1. Verificar se o número já existe
            $stmt_check = $pdo->prepare("SELECT telefone FROM cliente_rest WHERE telefone = ?");
            $stmt_check->execute([$numero_limpo]);
            
            if ($stmt_check->rowCount() > 0) {
                $mensagem = 'Este número já está cadastrado!';
            } else {
                // 2. Inserir novo número (usando nome padrão)
                $nome_cliente = 'Cliente WhatsApp'; 
                
                $stmt_insert = $pdo->prepare("INSERT INTO cliente_rest (nome, telefone) VALUES (?, ?)");
                $stmt_insert->execute([$nome_cliente, $numero_limpo]);
                
                // Redireciona para evitar reenvio do formulário
                header('Location: parabens.php?sucesso=true');
                exit;
            }
        } catch (PDOException $e) {
            $mensagem = 'Erro ao cadastrar: ' . $e->getMessage();
        }
        
    } else {
        $mensagem = 'Por favor, digite um número de WhatsApp válido (com DDD e 8 ou 9 dígitos).';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Uai Menu - Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css" />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600&family=Architects+Daughter&family=Tangerine:wght@700&display=swap" rel="stylesheet">
</head>

<body>

<main class="container my-5">
    <div class="row align-items-center">
        <div class="col-md-6 mb-4 mb-md-0 ">
            <div class="image-container-cadastrar">
                <img src="../imagens/espaguete.png" alt="Imagem de Comida Mineira" class="img-fluid rounded shadow" />
            </div>
        </div>
        <div class="col-md-6" >
            <div class="card shadow p-4 cadastros" >
                <h2 class="card-title mb-4" id="titulo-cadastro" >Envio diário</h2>
                
                <?php if ($mensagem): ?>
                    <div class="alert alert-danger text-center" role="alert">
                        <?php echo $mensagem; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="cadastro_cliente.php">
                    <div class="mb-3">
                        <p class="fs-5 fw-semibold text-center">Digite seu número do Whatsapp</p>
                        <input type="tel" 
                               class="form-control" 
                               id="Numero" 
                               name="Numero" 
                               placeholder="(xx) xxxxx-xxxx" 
                               maxlength="15" 
                               required>

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
    <script>
    // --- FUNÇÃO DE MÁSCARA PARA TELEFONE (JS) ---
    document.addEventListener('DOMContentLoaded', (event) => {
        const inputNumero = document.getElementById('Numero');

        const maskTelefone = (value) => {
            if (!value) return ""
            value = value.replace(/\D/g, '') // Remove tudo que não for dígito
            
            // 11 dígitos (celular)
            if (value.length > 10) {
                value = value.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3')
            // 10 dígitos (fixo ou celular antigo)
            } else if (value.length > 6) {
                value = value.replace(/^(\d{2})(\d{4})(\d{4})$/, '($1) $2-$3')
            // 6 ou menos
            } else if (value.length > 2) {
                value = value.replace(/^(\d{2})(\d+)$/, '($1) $2')
            } else {
                value = value.replace(/^(\d*)$/, '($1')
            }
            return value
        }

        inputNumero.addEventListener('keyup', (e) => {
            e.target.value = maskTelefone(e.target.value);
        });
        
        // Aplica a máscara no carregamento, caso o campo tenha valor prévio
        inputNumero.value = maskTelefone(inputNumero.value);
    });
    
    // Scripts de animação do rodapé (mantidos)
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