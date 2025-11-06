<?php
require_once __DIR__ . '/../../config/database.php';

class CardapioImagem {

    public static function buscar($dia) {
        $conn = Database::conectar();
        $stmt = $conn->prepare("SELECT imagem FROM cardapio_dia WHERE dia = :dia");
        $stmt->bindParam(':dia', $dia);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public static function atualizar($dia, $imagem) {
        $conn = Database::conectar();
        $stmt = $conn->prepare("UPDATE cardapio_dia SET imagem = :imagem WHERE dia = :dia");
        $stmt->bindParam(':imagem', $imagem);
        $stmt->bindParam(':dia', $dia);
        return $stmt->execute();
    }
}
