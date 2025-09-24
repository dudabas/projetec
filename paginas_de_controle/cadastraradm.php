<?php
// Dados de conexão
$servername = "localhost";
$username = "root";  // altere se seu usuário for diferente
$password = "";      // altere se seu MySQL tiver senha
$dbname = "uaimenu";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se os campos foram enviados
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirmarSenha = $_POST['confirmarSenha'];
    $senhaAdm = $_POST['senhaAdm'];

    // Validações básicas
    if ($senha !== $confirmarSenha) {
        die("Erro: as senhas não coincidem.");
    }

    // Hash da senha (recomendado para segurança)
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Inserir no banco
    $sql = "INSERT INTO adm (email, senha_adm, senha_propria, id_adm) VALUES (?, ?, ?, NULL)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sss", $email, $senhaAdm, $senhaHash);
        if ($stmt->execute()) {
            echo "<h3>Cadastro realizado com sucesso!</h3>";
            echo "<a href='cardapioadm.html'>Ir para administração</a>";
        } else {
            echo "Erro ao cadastrar: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Erro na preparação da query: " . $conn->error;
    }
}

$conn->close();
?>