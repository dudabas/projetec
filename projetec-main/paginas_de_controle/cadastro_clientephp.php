<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Uai Menu</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css" />
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600&family=Architects+Daughter&family=Tangerine:wght@700&display=swap" rel="stylesheet">
</head>

<body>
<header class="top-bar">
  <div class="icon-wrapper">
  <a href="index.html">
    <img src="./imagens/image.png" alt="Logo" class="logo" />
  </a>
</div>
  <nav class="menu">
    <div class="cardapio-dropdown">
      <a class="menulink" href="#" id="cardapio-link">Cardápio ▾</a>
      <div class="card-topbar" id="card-topbar" style="display: none;">
        <a href="cardapio.html" class="card-link">Ver cardápio do dia</a>
        <a href="cadastro_cliente.html" class="card-link">Receber diariamente</a>
        <a href="apagar_numero.html" class="card-link">Remover número</a>
      </div>
    </div>
    <a  class="menulink" href="cardapioadm.html">Administração</a>
    <a class="menulink" href="duvidas.html">Dúvidas</a>
  </nav>
</header>

<main class="container my-5">
    <div class="row align-items-center">
        <!-- Coluna da Imagem -->
        <div class="col-md-6 mb-4 mb-md-0 ">
            <div class="image-container-cadastrar">
                <img src="./imagens/espaguete.png" alt="Imagem de Comida Mineira" class="img-fluid rounded shadow" />
            </div>
        </div>
       <!-- Coluna do Formulario -->
      <div class="col-md-6">
        <div class="card shadow p-4 cadastros">
          <h2 class="card-title mb-4" id="titulo-cadastro">Envio diario</h2>

          <!-- Formulario -->
          <form id="formCadastro">
            <div class="mb-3">
              <p class="fs-5 fw-semibold text-center">Digite seu numero do Whatsapp</p>
              <input type="tel" class="form-control" id="Numero" name="numero" placeholder="(xx) xxxxx-xxxx" required>
            </div>
            <button href="Validacao_cliente.html" type="submit" class="btn btn-primary w-100" id="botao-cadastro">Enviar</button>
          </form>
          <div id="mensagem-sucesso" class="mt-3 text-success fw-bold" style="display: none;">
            Numeero cadastrado com sucesso!
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
    // Rodape animado ao rolar
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

    // Mostrar/esconder menu cardapio
    const link = document.getElementById("cardapio-link");
    const cardTopbar = document.getElementById("card-topbar");

    link.addEventListener("click", function (e) {
      e.preventDefault();
      cardTopbar.style.display = cardTopbar.style.display === "block" ? "none" : "block";
    });

    // Enviar dados do formulurio via fetch
    document.getElementById("formCadastro").addEventListener("submit", function (e) {
      e.preventDefault();
      const numero = document.getElementById("Numero").value;

      fetch('salvar.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'numero=' + encodeURIComponent(numero)
      })
        .then(response => response.text())
        .then(data => {
          if (data.trim() === "success") {
            document.getElementById("mensagem-sucesso").style.display = "block";
            document.getElementById("formCadastro").reset();
          } else {
            alert("Erro: " + data);
          }
        })
        .catch(error => {
          alert("Erro na requisisao: " + error);
        });
    });
  </script>
</body>
</html>


