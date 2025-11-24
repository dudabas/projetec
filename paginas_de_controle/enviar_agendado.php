<?php
require_once "conexao.php";

// Config Meta (mesmos dados do enviar.php)
$token = "EAASD82JnjE0BQHFVojZBvtY31Xy6U3ZBUrnKE2ZCR6Ao5HZB4znaMenuwFM6ci6TkZBlNsctvsW56lkIPZAhjyQxxCsETxafwDw2vxGp8X5rVjnwC9Q1R5hLL3om4ZAjQjtqGCaeRZC9CxI50eQ4XFXBkLuGIa7heR4XHS1nOdj9WUtfQSmGYUgQ0F7Wi6QzCe4l1jU8uIDtbfF4dhsIcaRkGZAqZAKIwYzRCIYhZCZASZAmVK8tLijmHw9BuogZAQAI3mseyZAYNafne6LGSe1casM7FL6ySYR6QZDZD";
$phone_number_id = "809271902276522";
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

    $nome = $c["nome"];
    $telefone = $c["telefone"];

    $mensagem = "Olá $nome! Houve uma atualização no cardápio diário de hoje ($dataHoje). Confira aqui: $linkCardapio";

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
