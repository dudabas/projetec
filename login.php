<?php
session_start();

// Configurações do Banco de Dados
$servername = "localhost";
$username = "root";
$password = ""; // Se você usa XAMPP/WAMP padrão, a senha geralmente é vazia
$dbname = "uaimenu";

// Tenta Conexão
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    // Redireciona com erro de conexão, armazena o erro na sessão
    // Isso só acontece se o MySQL estiver parado, o que você disse que não é o caso.
    $_SESSION['erro'] = "Erro de conexão com o banco de dados. Contate o suporte.";
    header("Location: entraradm.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // O nome 'email' e 'senha' vêm do formulário (que usa name="email" e name="senha")
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $sql = "SELECT id_adm, email, senha_propria FROM adm WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        $_SESSION['erro'] = "Erro interno ao preparar o login.";
        header("Location: entraradm.php");
        exit();
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        // 🔑 PONTO CRÍTICO: Verifica a senha hasheada (coluna senha_propria)
        if (password_verify($senha, $usuario['senha_propria'])) {
            
            // Login bem-sucedido: Define as variáveis de Sessão
            if(isset($_SESSION['erro'])) {
                unset($_SESSION['erro']);
            }
            $_SESSION['admin_logado'] = true; 
            $_SESSION['admin_id'] = $usuario['id_adm']; 
            $_SESSION['admin_email'] = $usuario['email'];

            // Redirecionamento para o painel principal
            header("Location: cardapioadm.php");
            exit();
        } else {
            // Senha incorreta
            $_SESSION['erro'] = "Senha incorreta para o email fornecido.";
        }
    } else {
        // Email não encontrado (Isso deve ser resolvido após o passo 1/2)
        $_SESSION['erro'] = "Email não cadastrado. Verifique o endereço e tente novamente.";
    }

    $stmt->close();
}

$conn->close();

// Redireciona de volta para a tela de login se houver erro ou se não for POST
header("Location: entraradm.php");
exit();
?>