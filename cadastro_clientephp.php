<?php
// Define as credenciais do Banco de Dados
$host = 'localhost'; 
$db   = 'uaiMenu';   
$user = 'root';      // **ATENÇÃO:** Mude para o seu usuário do banco de dados
$pass = '';          // **ATENÇÃO:** Mude para a sua senha do banco de dados

// Configurações do DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lançar exceções em caso de erro
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Retornar dados como array associativo
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Cria a conexão PDO
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Em caso de falha na conexão, encerra o script e exibe o erro
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
    // Você pode usar die() se preferir: die("Erro de Conexão: " . $e->getMessage());
}

// A variável $pdo está agora disponível para ser usada em outros arquivos.
?>