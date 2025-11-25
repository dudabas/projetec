<?php
require_once "conexao.php";

// Config Meta (mesmos dados do enviar.php)
$token = "SEU_TOKEN_DO_META";
$phone_number_id = "SEU_PHONE_NUMBER_ID";
$url = "https://graph.facebook.com/v19.0/$phone_number_id/messages";


// =============================
// VERIFICAR SE JÁ FOI ENVIADO HOJE
// =============================
$hoje = date("Y-m-d");

$sql = "SELECT * FROM controle_envio WHERE data_envio = '$hoje' LIMIT 1";
$res = $con->query($sql);

if ($res->num_rows > 0) {
    die("Já enviado hoje ($hoje). Encerrando.\n");
}


// =============================
// PEGAR CLIENTES
// =============================
$sql = "SELECT nome, telefone FROM cliente_rest";
$clientes = $con->query($sql);

if ($clientes->num_rows == 0) {
    die("Nenhum cliente encontrado.\n");
}


// =============================
// ENVIAR MENSAGEM
// =============================
$linkCardapio = "https://dudabas.github.io/cardapio.php";
$dataHoje = date("d/m/Y");

while ($c = $clientes->fetch_assoc()) {

    
    $telefone = $c["telefone"];

    $mensagem = " Houve uma atualização no cardápio diário de hoje ($dataHoje). Confira aqui: $linkCardapio";

    $data = [
        "messaging_product" => "whatsapp",
        "to" => "55$telefone",
        "type" => "text",
        "text" => ["body" => $mensagem]
    ];

    $json = json_encode($data);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $token",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
}


// =============================
// GRAVAR QUE FOI ENVIADO HOJE
// =============================
$con->query("INSERT INTO controle_envio (data_envio) VALUES ('$hoje')");

echo "Envio automático concluído em $dataHoje\n";
?>
