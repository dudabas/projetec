<?php
// Inclui o arquivo de conexão PDO. Agora temos a variável $pdo disponível.
require_once "cadastro_clientephp.php"; 

// --- Config Meta ---
$token = "EAASD82JnjE0BQEjjEHgOqewZAok33VpS16DrWJEOOwFr1xFQaNvMcxtXgKmxs3kNgcI2SLqYh2vWOO9aXWH1EFFvXW8x22UFqr16cy1Q7KZAdoPp7kiun62QNpSDE8sGDtpF8wIuizMCGWoCnpPzzDRz7VJARAHJ0lakaTxMXMr2BHE1FzWP6F03fborRu4KxBTKshfV2EPMmvilwAjmQ0wipOuYw0SeIBPf8dowxT8CJuEtNrP5bSZBtCRYTQ9LFoZCjA47Jwx71uwsZANURBVG5";
$phone_number_id = "809271902276522";
$url = "https://graph.facebook.com/v19.0/$phone_number_id/messages";

$dataHoje = date("d/m/Y");
$linkCardapio = "https://dudabas.github.io/cardapio.php";


// ========================================
// 1. PEGAR CLIENTES (usando PDO)
// ========================================
try {
    $stmt_clientes = $pdo->query("SELECT nome, telefone FROM cliente_rest");
    $clientes = $stmt_clientes->fetchAll(PDO::FETCH_ASSOC);

    if (empty($clientes)) {
        die("⚠️ Nenhum cliente encontrado.\n");
    }
} catch (PDOException $e) {
    die("❌ Erro de DB (Clientes): " . $e->getMessage() . "\n");
}


$sucessos = 0;
$falhas = 0;

foreach ($clientes as $c) {
    
    // LIMPEZA E FORMATAÇÃO DO TELEFONE (55DDnúmero)
    $telefone_limpo = preg_replace('/\D/', '', $c["telefone"]);
    $telefone_destino = "55" . $telefone_limpo; 
    
    $mensagem = "Olá " . $c["nome"] . "! Houve uma atualização no cardápio diário de hoje ($dataHoje). Confira aqui: $linkCardapio";

    $data = [
        "messaging_product" => "whatsapp",
        "to" => $telefone_destino,
        "type" => "text",
        "text" => ["body" => $mensagem]
    ];

    $json = json_encode($data);

    // Inicialize e configure o cURL
    $ch = curl_init($url);
    // ... (configurações do cURL) ...
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $resposta_api = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // TRATAMENTO DE ERROS (AGORA INCLUI O NÚMERO)
    if (curl_errno($ch)) {
        // MENSAGEM DE ERRO COM NÚMERO
        echo "❌ Falha cURL para " . $c["nome"] . " (Número: $telefone_destino): " . curl_error($ch) . "\n";
        $falhas++;
    } 
    else if ($http_status >= 400) {
        $erro_api = json_decode($resposta_api, true);
        $erro_msg = isset($erro_api['error']['message']) ? $erro_api['error']['message'] : $resposta_api;
        
        // MENSAGEM DE ERRO DE API COM NÚMERO
        echo "❌ Falha API para " . $c["nome"] . " (Número: $telefone_destino). Status: $http_status. Erro: " . $erro_msg . "\n";
        $falhas++;
    }
    else {
        // MENSAGEM DE SUCESSO COM NÚMERO
        echo "✅ Sucesso para " . $c["nome"] . " (Número: $telefone_destino). Status: $http_status\n";
        $sucessos++;
    }
    
    curl_close($ch);
    
    // PAUSA ENTRE ENVIOS
    usleep(500000); 
}


echo "\n--- Relatório Final ---\n";
// ... (resto do relatório final) ...
?>