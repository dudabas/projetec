<?php
session_start();

// 🚨 Verificação de Segurança: Redireciona se o admin não estiver logado
if (!isset($_SESSION['admin_logado']) || $_SESSION['admin_logado'] !== true) {
    header("Location: entraradm.php");
    exit();
}
require '../config.php';
require INC_PATH . '/header.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uai Menu - Painel Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&family=Architects+Daughter&display=swap" rel="stylesheet">
    <!-- ATUALIZADO: Usando Bootstrap 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
    
    <style>
        /* Estilos adicionais para o cardápio e o botão de logout */
        .card-title {
            font-family: 'Architects Daughter', cursive;
            font-size: 1.5rem;
        }
        /* Botão de Edição Revertido para o estilo anterior */
        .btn-uai {
            background-color: #ff9900; /* Cor Laranja/Amarela */
            border-color: #ff9900;
            color: #fff;
            /* Estilos de largura e margem foram removidos, usando o padrão do Bootstrap */
        }
        .btn-uai:hover {
            background-color: #e68a00;
            border-color: #e68a00;
            color: #fff;
        }
        .btn-logout { 
            background-color: #dc3545; /* Cor Vermelha para sair */
            border: none; 
            transition: background-color 0.3s;
        }
        .btn-logout:hover {
            background-color: #c82333;
        }
        .card-logout {
            margin-top: 30px;
            padding: 20px;
            background-color: #fff;
        }
    </style>
</head>
<body>

<main class="container my-4">
    <h1 class="text-center mb-5" style="font-family: 'Architects Daughter', cursive; color: #ff9900;">
        Gerenciamento do Cardápio Semanal
    </h1>
    
    <section class="row g-4">
        <!-- Segunda-feira -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100" id="dia">
                <img src="../imagens/comida.png" class="card-img-top" alt="Segunda-feira">
                <div class="card-body">
                    <h5 class="card-title">Segunda-feira</h5>
                    <a href="../dias_da_semana/cardapiosegunda.php" class="btn btn-primary">Clique para acessar o cardápio de segunda-feira</a>
                </div>
                <div class="mt-auto text-center">
                    <a href="../edicao/cardapioadmsegunda.php" class="btn btn-uai btn-sm">Editar Cardápio</a>
                </div>
            </div>
        </div>

        <!-- Terça-feira -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100" id="dia">
                <img src="../imagens/comida.png" class="card-img-top" alt="Terça-feira">
                <div class="card-body">
                    <h5 class="card-title">Terça-feira</h5>
                    <a href="../dias_da_semana/cardapioterca.php" class="btn btn-primary">Clique para acessar o cardápio de terça-feira</a>
                </div>
                <div class="mt-auto text-center">
                    <a href="../edicao/cardapioadmterca.php" class="btn btn-uai btn-sm" >Editar Cardápio</a>
                </div>
            </div>
        </div>

        <!-- Quarta-feira -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100" id="dia">
                <img src="../imagens/comida.png" class="card-img-top" alt="Quarta-feira">
                <div class="card-body">
                    <h5 class="card-title">Quarta-feira</h5>
                    <a href="../dias_da_semana/cardapioquarta.php" class="btn btn-primary">Clique para acessar o cardápio de quarta-feira</a>
                </div>
                <div class="mt-auto text-center">
                    <a href="../edicao/cardapioadmquarta.php" class="btn btn-uai btn-sm" >Editar Cardápio</a>
                </div>
            </div>
        </div>

        <!-- Quinta-feira -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100" id="dia">
                <img src="../imagens/comida.png" class="card-img-top" alt="Quinta-feira">
                <div class="card-body">
                    <h5 class="card-title">Quinta-feira</h5>
                    <a href="../dias_da_semana/cardapioquinta.php" class="btn btn-primary">Clique para acessar o cardápio de quinta-feira</a>
                </div>
                <div class="mt-auto text-center">
                    <a href="../edicao/cardapioadmquinta.php" class="btn btn-uai btn-sm" >Editar Cardápio</a>
                </div>
            </div>
        </div>

        <!-- Sexta-feira -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100" id="dia">
                <img src="../imagens/comida.png" class="card-img-top" alt="Sexta-feira">
                <div class="card-body">
                    <h5 class="card-title">Sexta-feira</h5>
                    <a href="../dias_da_semana/cardapiosexta.php" class="btn btn-primary">Clique para acessar o cardápio de sexta-feira</a>
                </div>
                <div class="mt-auto text-center">
                    <a href="../edicao/cardapioadmsexta.php" class="btn btn-uai btn-sm" >Editar Cardápio</a>
                </div>
            </div>
        </div>
        <!-- Sabado -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100" id="dia">
                <img src="../imagens/comida.png" class="card-img-top" alt="Sábado">
                <div class="card-body">
                    <h5 class="card-title">Sábado</h5>
                    <a href="../dias_da_semana/cardapiosabado.php" class="btn btn-primary">Clique para acessar o cardápio de Sábado</a>
                </div>
                <div class="mt-auto text-center">
                    <a href="../edicao/cardapioadmsabado.php" class="btn btn-uai btn-sm" >Editar Cardápio</a>
                </div>
            </div>
        </div>

    </section>

    <!-- Seção e Botão de Logout (Mantido) -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card card-logout shadow">
                <div class="card-body p-3">
                    <h5 class="card-title text-center mb-3">Opções da Área Administrativa</h5>
                    <div class="d-grid gap-2">
                        <a href="logout.php" class="btn btn-lg btn-logout text-white" role="button">
                            Sair / Deslogar do Painel
                        </a>
                    </div>
                </div>
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
<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>