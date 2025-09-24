<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "uaimenu";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $sql = "SELECT * FROM adm WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Erro ao preparar statement: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($senha, $usuario['senha_propria'])) {
           
            $_SESSION['usuario_id'] = $usuario['id_adm'];
            $_SESSION['usuario_email'] = $usuario['email'];

            header("Location: cardapioadm.html");
            exit();
        } else {
            echo "<p style='color:red; text-align:center;'>Senha incorreta!</p>";
            echo "<a href='login.html'>Tentar novamente</a>";
        }
    } else {
        echo "<p style='color:red; text-align:center;'>Email não encontrado!</p>";
        echo "<a href='login.html'>Tentar novamente</a>";
    }

    $stmt->close();
}

$conn->close();
?>
