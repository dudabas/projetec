<?php
session_start();

// Assume a porta 3306. Se você mudou no XAMPP, altere para 'localhost', 'root', '', 'uaimenu', [NOVA_PORTA]
$conn = new mysqli("localhost", "root", "", "uaimenu");

if ($conn->connect_error) {
    // É uma boa prática não mostrar a mensagem bruta de erro de conexão para o usuário final
    $_SESSION['erro'] = "Erro de conexão com o banco de dados. Contate o suporte.";
    header("Location: cadastraradm.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $confirmarSenha = $_POST['confirmarSenha'];
    $senhaAdm = $_POST['senhaAdm'];
    $is_first_admin = false;

    // 1. Validações Iniciais
    // ... (Validação de Email, Complexidade e Confirmação de Senha continuam iguais)

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['erro'] = "E-mail inválido. Por favor, insira um e-mail válido.";
        header("Location: cadastraradm.php");
        exit;
    }

    $regexSenha = '/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
    if (!preg_match($regexSenha, $senha)) {
        $_SESSION['erro'] = "A senha deve ter no mínimo 8 caracteres e conter letras, números e caracteres especiais.";
        header("Location: cadastraradm.php");
        exit;
    }

    if ($senha !== $confirmarSenha) {
        $_SESSION['erro'] = "As senhas (Senha e Confirmação) não coincidem.";
        header("Location: cadastraradm.php");
        exit;
    }

    // 2. Verifica se o email já está em uso
    $sqlVerificaEmail = "SELECT email FROM adm WHERE email = ?";
    $stmtEmail = $conn->prepare($sqlVerificaEmail);
    $stmtEmail->bind_param("s", $email);
    $stmtEmail->execute();
    $stmtEmail->store_result();

    if ($stmtEmail->num_rows > 0) {
        $_SESSION['erro'] = "Este e-mail já está cadastrado no sistema.";
        header("Location: cadastraradm.php");
        exit;
    }
    $stmtEmail->close();


    // 3. 🚨 NOVA LÓGICA: Verifica se já existe algum administrador 🚨
    $sqlCount = "SELECT COUNT(*) as total FROM adm";
    $resultadoCount = $conn->query($sqlCount);
    $row = $resultadoCount->fetch_assoc();
    $totalAdmins = (int) $row['total'];

    if ($totalAdmins === 0) {
        // Se a tabela está vazia, este é o primeiro admin.
        // Remove a exigência da senhaAdm, mas registra o status.
        $is_first_admin = true;
        $senhaAdmBanco = 'PRIMEIRO_CADASTRO'; // Placeholder ou valor nulo para o INSERT
        
        // Se este é o primeiro cadastro, podemos optar por não exigir 'senhaAdm' no formulário.
        // Se 'senhaAdm' foi enviada e não está vazia, podemos usá-la como a senha padrão.
        if (!empty($senhaAdm)) {
            $senhaAdmBanco = $senhaAdm;
        } else {
             // Caso não seja enviada, define uma senha padrão simples para o primeiro admin
             // (Esta senha só será usada para AUTORIZAR futuros cadastros)
             $senhaAdmBanco = 'adm123'; 
        }

    } else {
        // Se já existem administradores, a senhaAdm é obrigatória
        $sqlVerificaAdm = "SELECT senha_adm FROM adm LIMIT 1";
        $resultado = $conn->query($sqlVerificaAdm);
        
        if ($resultado && $resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
            $senhaAdmBanco = $row['senha_adm'];

            // Validação da senha de administrador
            if ($senhaAdm !== $senhaAdmBanco) {
                $_SESSION['erro'] = "Senha de administrador incorreta. Você não tem permissão para cadastrar.";
                header("Location: cadastraradm.php");
                exit;
            }
        } else {
             // Caso de erro improvável, onde COUNT > 0, mas SELECT retorna 0
             $_SESSION['erro'] = "Erro interno: Falha ao validar administrador existente.";
             header("Location: cadastraradm.php");
             exit;
        }
    }


    // 4. Tudo certo — cadastra o novo admin
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Ajusta a query de INSERT:
    if ($is_first_admin) {
        // Se for o primeiro admin, insere a senha_adm para futuros cadastros (usando o valor definido acima)
        $sql = "INSERT INTO adm (email, senha_propria, senha_adm) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $email, $senhaHash, $senhaAdmBanco);

    } else {
        // Para admins subsequentes, a senha_adm não muda, então inserimos só email e senha_propria
        $sql = "INSERT INTO adm (email, senha_propria) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $senhaHash);
    }
    
    // Execução da Query
    if ($stmt) {
        if ($stmt->execute()) {
            // Sucesso no cadastro.
            $_SESSION['admin_logado'] = true;
            $_SESSION['admin_email'] = $email;
            
            header("Location: cardapioadm.php");
            exit;
        } else {
            $_SESSION['erro'] = "Erro ao cadastrar: " . $stmt->error;
            header("Location: cadastraradm.php");
            exit;
        }
        $stmt->close();
    } else {
        $_SESSION['erro'] = "Erro na preparação da query SQL. Contate o suporte.";
        header("Location: cadastraradm.php");
        exit;
    }
}

$conn->close();
?>