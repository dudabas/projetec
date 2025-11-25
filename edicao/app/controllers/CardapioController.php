<?php

require_once __DIR__ . '/../models/Carne.php';
require_once __DIR__ . '/../models/Acompanhamento.php';
require_once __DIR__ . '/../models/Salada.php';
require_once __DIR__ . '/../models/CardapioImagem.php';
require_once __DIR__ . '/../../config/database.php';

class CardapioController {

    public function getDados(string $dia): array {
        return [
            'dia' => $dia,
            'carne' => Carne::buscar($dia),
            'acomp' => Acompanhamento::buscar($dia),
            'salada' => Salada::buscar($dia),
            'imagem' => CardapioImagem::buscar($dia)
        ];
    }

    public function salvar(string $dia): string {

        // Buscar valores atuais do banco
        $carneAtual = Carne::buscar($dia);
        $acompAtual = Acompanhamento::buscar($dia);
        $saladaAtual = Salada::buscar($dia);
        $imgAtual = CardapioImagem::buscar($dia);

        // Novo valor OU mantém o antigo
        $novaCarne = ($_POST['carne'] !== "") ? $_POST['carne'] : $carneAtual;
        $novoAcomp = ($_POST['acompanhamento'] !== "") ? $_POST['acompanhamento'] : $acompAtual;
        $novaSalada = ($_POST['salada'] !== "") ? $_POST['salada'] : $saladaAtual;

        $conn = Database::conectar();

        // SALVAR CARNE
        $sql = "INSERT INTO carne (dia, carne) VALUES (:dia, :texto)
                ON DUPLICATE KEY UPDATE carne = :texto";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':dia' => $dia, ':texto' => $novaCarne]);

        // SALVAR ACOMPANHAMENTO
        $sql = "INSERT INTO acompanhamento (dia, acompanhamento) VALUES (:dia, :texto)
                ON DUPLICATE KEY UPDATE acompanhamento = :texto";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':dia' => $dia, ':texto' => $novoAcomp]);

        // SALVAR SALADA
        $sql = "INSERT INTO salada (dia, salada) VALUES (:dia, :texto)
                ON DUPLICATE KEY UPDATE salada = :texto";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':dia' => $dia, ':texto' => $novaSalada]);

        // SALVAR IMAGEM (somente se enviada)
        if (!empty($_FILES['imagem']['name'])) {

            $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
            $nomeArquivo = $dia . "_" . time() . "." . $ext;
            $destino = __DIR__ . "/../../imagens/" . $nomeArquivo;

            move_uploaded_file($_FILES['imagem']['tmp_name'], $destino);

            $sql = "INSERT INTO cardapio_dia (dia, imagem) VALUES (:dia, :img)
                    ON DUPLICATE KEY UPDATE imagem = :img";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':dia' => $dia, ':img' => 'imagens/' . $nomeArquivo]);
        }

        return "Alterações salvas com sucesso!";
    }
}
