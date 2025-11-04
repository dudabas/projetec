<?php
require_once __DIR__ . '/../../config/database.php';

class Salada {
    public static function buscar($dia) {
        $conn = Database::conectar();
        $stmt = $conn->prepare("SELECT salada FROM salada WHERE dia = :dia LIMIT 1");
        $stmt->bindParam(':dia', $dia);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['salada'] ?? '';
    }

    public static function atualizar($dia, $nova) {
        $conn = Database::conectar();
        $stmt = $conn->prepare("UPDATE salada SET salada = :salada WHERE dia = :dia");
        $stmt->bindParam(':salada', $nova);
        $stmt->bindParam(':dia', $dia);
        return $stmt->execute();
    }
}
?>
