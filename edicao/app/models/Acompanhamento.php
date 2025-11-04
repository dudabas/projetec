<?php
require_once __DIR__ . '/../../config/database.php';

class Acompanhamento {
    public static function buscar($dia) {
        $conn = Database::conectar();
        $stmt = $conn->prepare("SELECT acompanhamento FROM acompanhamento WHERE dia = :dia LIMIT 1");
        $stmt->bindParam(':dia', $dia);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['acompanhamento'] ?? '';
    }

    public static function atualizar($dia, $novo) {
        $conn = Database::conectar();
        $stmt = $conn->prepare("UPDATE acompanhamento SET acompanhamento = :acompanhamento WHERE dia = :dia");
        $stmt->bindParam(':acompanhamento', $novo);
        $stmt->bindParam(':dia', $dia);
        return $stmt->execute();
    }
}
?>
