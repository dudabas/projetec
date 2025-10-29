<?php
session_start(); // permite armazenar mensagens de erro temporárias

$conn = new mysqli("localhost", "root", "", "uaimenu");

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $confirmarSenha = $_POST['confirmarSenha'];
    $senhaAdm = $_POST['senhaAdm'];

    // 🔸 Verifica se as senhas coincidem
    if ($senha !== $confirmarSenha) {
        $_SESSION['erro'] = "As senhas não coincidem.";
        header("Location: cadastraradm.html");
        exit;
    }

    // 🔸 Valida o formato do email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['erro'] = "E-mail inválido.";
        header("Location: cadastraradm.html");
        exit;
    }

    // 🔸 Verifica a senha de administrador
    $sqlVerificaAdm = "SELECT senha_adm FROM adm LIMIT 1";
    $resultado = $conn->query($sqlVerificaAdm);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $senhaAdmBanco = $row['senha_adm'];

        if ($senhaAdm !== $senhaAdmBanco) {
            $_SESSION['erro'] = "Senha de administrador incorreta.";
            header("Location: cadastraradm.html");
            exit;
        }
    } else {
        $_SESSION['erro'] = "Nenhum administrador encontrado no sistema.";
        header("Location: cadastraradm.html");
        exit;
    }

    // 🔸 Tudo certo — cadastra o novo admin
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    $sql = "INSERT INTO adm (email, senha_adm, senha_propria) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sss", $email, $senhaAdmBanco, $senhaHash);

        if ($stmt->execute()) {
            // sucesso — redireciona para o painel
            header("Location: cardapioadm.html");
            exit;
        } else {
            $_SESSION['erro'] = "Erro ao cadastrar: " . $stmt->error;
            header("Location: cadastraradm.html");
            exit;
        }

        $stmt->close();
    } else {
        $_SESSION['erro'] = "Erro na preparação da query.";
        header("Location: ccadastraradm.html");
        exit;
    }
}

$conn->close();
?>
