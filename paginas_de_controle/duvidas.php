<?php require '../config.php';
require INC_PATH . '/header.php';?>
<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Uai Menu</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&family=Tangerine:wght@700&display=swap"
      rel="stylesheet">
    <link
      href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600&family=Architects+Daughter&display=swap"
      rel="stylesheet">
      <link rel="stylesheet" href="../styles.css">
  </head>
<body>
  <main>
  <h1 class="duvidas-h1">Uai sô, que menu!</h1>

  <div class="content">
    <h2>Dúvidas frequentes</h2>

    <h3>Como eu faço para receber o cardápio diário?</h3>
    <div class="faq-box">
      <ul>
        <li>Clique com o mouse na seta ao lado do “CARDÁPIO” na parte superior da tela.</li>
        <li>Clique na opção “Receber diariamente”.</li>
        <li>Insira o seu número.</li>
        <li>Digite o código enviado para o seu celular e pronto! Você receberá envios diários do cardápio no seu WhatsApp</li>
      </ul>
    </div>

    <h3>Onde eu recebo o cardápio diário:</h3>
    <div class="faq-box">
      <ul>
        <li>O cardápio será enviado para o seu WhatsApp através de um contato do restaurante.</li>
      </ul>
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
