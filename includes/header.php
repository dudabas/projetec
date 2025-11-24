<?php

$BASE_PATH = "/projetec-maindefinitiva/";

if (!isset($page_title)) {
    $page_title = "PROJETEC - Seu Sistema";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <!-- CSS usa o caminho absoluto -->
    <link rel="stylesheet" href="<?php echo $BASE_PATH; ?>caminho/para/estilos.css">
</head>
<body>

<header class="top-bar">
    <div class="icon-wrapper">
        
        <a href="<?php echo $BASE_PATH; ?>index.php">
            <img src="<?php echo $BASE_PATH; ?>imagens/image.png" alt="Logo" class="logo" />
        </a>
    </div>
    <nav class="menu">
        <div class="cardapio-dropdown">
            <a class="menulink" href="#" id="cardapio-link">Cardápio ▾</a>
            <div class="card-topbar" id="card-topbar" style="display: none;">
                <!-- CORRIGIDO: Adicionado class="card-link" ao primeiro link do dropdown -->
                <a href="<?php echo $BASE_PATH; ?>paginas_de_controle/cardapio.php" class="card-link">Ver cardápio do dia</a>
                <a href="<?php echo $BASE_PATH; ?>paginas_de_controle/cadastro_cliente.php" class="card-link">Receber diariamente</a>
                <a href="<?php echo $BASE_PATH; ?>paginas_de_controle/apagar_numero.php" class="card-link">Remover Número</a>
            </div>
        </div>
        <!-- LINKS DE NAVEGAÇÃO AGORA SÃO ABSOLUTOS -->
        <a class="menulink" href="<?php echo $BASE_PATH; ?>paginas_de_controle/entraradm.php">Administração</a>
        <a class="menulink" href="<?php echo $BASE_PATH; ?>paginas_de_controle/duvidas.php">Dúvidas</a>
    </nav>
</header>
