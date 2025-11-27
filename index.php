<?php 
require 'config.php';
require INC_PATH . '/header.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Uai Menu</title>
  <link rel="stylesheet" href="styles.css" />
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&family=Tangerine:wght@700&display=swap"rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600&family=Architects+Daughter&display=swap"rel="stylesheet">
</head>

<body>

<main>
  <div style="margin: 40px 0 10px;">
    <h1>Uai sô, que menu!</h1>
    </div>

  <div class="image-container">
      <img src="imagens/comida.png" alt="Imagem de Comida Mineira" />
    </div>
    <section class="intro-text">
      <h2>Bem-vindo ao Uai Menu! Seu acesso ao cardápio mineiro a um clique de distância</h2>
      <p>
        Para consultar o cardápio, vá até a barra de menu e clique na setinha ao lado de “Cardápio”.
        Em seguida, selecione o dia da semana desejado para ver as opções disponíveis. Navegue entre os dias e
        descubra o que preparamos para você!
      </p>
    </section>
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
