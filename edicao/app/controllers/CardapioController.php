<?php
require_once __DIR__ . '/../models/Carne.php';
require_once __DIR__ . '/../models/Acompanhamento.php';
require_once __DIR__ . '/../models/Salada.php';

class CardapioController {
    public static function getDados($dia) {
        return [
            'carne' => Carne::buscar($dia),
            'acompanhamento' => Acompanhamento::buscar($dia),
            'salada' => Salada::buscar($dia)
        ];
    }

    public static function salvar($dia, $carne, $acomp, $salada) {
        $ok1 = Carne::atualizar($dia, $carne);
        $ok2 = Acompanhamento::atualizar($dia, $acomp);
        $ok3 = Salada::atualizar($dia, $salada);
        return $ok1 && $ok2 && $ok3;
    }
}
?>
