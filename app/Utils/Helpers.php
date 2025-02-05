<?php

namespace App\Utils;

class Helpers {
    // Função para verificar se uma key dentro do Array existe (key é uma determinada posição do array)
    static function getValorSeExiste($key, array $array) {
        if (empty($array) || is_null($array)) return null;
        if (array_key_exists($key, $array)) {
            return $array[$key];
        }
        return null;
    }
}
