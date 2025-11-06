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
        $msg = '';
        $conn = null;

        try {
            $conn = Database::conectar();
            $conn->beginTransaction();

            
            $sqlCarne = "INSERT INTO carne (dia, carne) VALUES (:dia, :texto)
                         ON DUPLICATE KEY UPDATE carne = :texto";
            $stmt = $conn->prepare($sqlCarne);
            $textoCarne = $_POST['carne'] ?? '';
            $stmt->bindParam(':dia', $dia);
            $stmt->bindParam(':texto', $textoCarne);
            $stmt->execute();

           
            $sqlAcomp = "INSERT INTO acompanhamento (dia, acompanhamento) VALUES (:dia, :texto)
                         ON DUPLICATE KEY UPDATE acompanhamento = :texto";
            $stmt = $conn->prepare($sqlAcomp);
            $textoAcomp = $_POST['acompanhamento'] ?? '';
            $stmt->bindParam(':dia', $dia);
            $stmt->bindParam(':texto', $textoAcomp);
            $stmt->execute();

            
            $sqlSalada = "INSERT INTO salada (dia, salada) VALUES (:dia, :texto)
                          ON DUPLICATE KEY UPDATE salada = :texto";
            $stmt = $conn->prepare($sqlSalada);
            $textoSalada = $_POST['salada'] ?? '';
            $stmt->bindParam(':dia', $dia);
            $stmt->bindParam(':texto', $textoSalada);
            $stmt->execute();

            
            if (!empty($_FILES['imagem']['name'])) {
                $file = $_FILES['imagem'];

                
                $allowed = ['image/jpeg','image/png','image/webp','image/gif'];
                if (!in_array($file['type'], $allowed)) {
                    throw new Exception("Formato de imagem inválido. Use JPG, PNG, WEBP ou GIF.");
                }
                if ($file['size'] > 5 * 1024 * 1024) {
                    throw new Exception("Imagem muito grande (máx 5MB).");
                }

                
                $destDir = __DIR__ . '/../../imagens/';
                if (!is_dir($destDir)) {
                    if (!mkdir($destDir, 0755, true)) {
                        throw new Exception("Falha ao criar pasta de imagens.");
                    }
                }

               
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $safeName = preg_replace('/[^a-z0-9_\-\.]/i', '', $dia . "_" . time() . "." . $ext);
                $destPath = $destDir . $safeName;

                if (!move_uploaded_file($file['tmp_name'], $destPath)) {
                    throw new Exception("Erro ao mover o arquivo enviado.");
                }

                
                $insDia = $conn->prepare("INSERT IGNORE INTO cardapio_dia (dia) VALUES (:dia)");
                $insDia->bindParam(':dia', $dia);
                $insDia->execute();

                $relPath = 'imagens/' . $safeName;
                $upd = $conn->prepare("UPDATE cardapio_dia SET imagem = :imagem WHERE dia = :dia");
                $upd->bindParam(':imagem', $relPath);
                $upd->bindParam(':dia', $dia);
                $upd->execute();
            }

            $conn->commit();
            $msg = "Alterações salvas com sucesso!";
        } catch (Exception $e) {
            if ($conn && $conn->inTransaction()) {
                $conn->rollBack();
            }
        
            $msg = "Erro ao salvar: " . $e->getMessage();
        }

        return $msg;
    }
}
