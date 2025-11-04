<?php
require_once __DIR__ . '/../../config/database.php';

class Carne {
    public static function buscar($dia) {
        $conn = Database::conectar();
        $stmt = $conn->prepare("SELECT carne FROM carne WHERE dia = :dia LIMIT 1");
        $stmt->bindParam(':dia', $dia);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['carne'] ?? '';
    }

    public static function atualizar($dia, $novaCarne) {
        $conn = Database::conectar();
        $stmt = $conn->prepare("UPDATE carne SET carne = :carne WHERE dia = :dia");
        $stmt->bindParam(':carne', $novaCarne);
        $stmt->bindParam(':dia', $dia);
        return $stmt->execute();
    }
}
?>
