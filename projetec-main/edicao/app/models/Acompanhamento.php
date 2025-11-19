<?php

require_once __DIR__ . '/../../config/database.php';

class Acompanhamento {
    public static function buscar($dia) {
        $conn = Database::conectar();
        $stmt = $conn->prepare("SELECT acompanhamento FROM acompanhamento WHERE dia = :dia LIMIT 1");
        $stmt->bindParam(':dia', $dia);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['acompanhamento'] ?? '';
    }

    public static function atualizar($dia, $texto) {
        $conn = Database::conectar();
        $stmt = $conn->prepare("UPDATE acompanhamento SET acompanhamento = :texto WHERE dia = :dia");
        $stmt->bindParam(':texto', $texto);
        $stmt->bindParam(':dia', $dia);
        $ok = $stmt->execute();
        if (!$ok || $stmt->rowCount() === 0) {
            try {
                $ins = $conn->prepare("INSERT INTO acompanhamento (acompanhamento, dia) VALUES (:texto, :dia)");
                $ins->bindParam(':texto', $texto);
                $ins->bindParam(':dia', $dia);
                $ins->execute();
                $ok = true;
            } catch (Exception $e) {}
        }
        return (bool)$ok;
    }
}

