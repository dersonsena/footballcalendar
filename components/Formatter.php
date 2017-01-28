<?php

namespace app\components;

use RuntimeException;
use yii\helpers\Html;
use yii\i18n\Formatter as YiiFormatter;

class Formatter extends YiiFormatter
{
    /**
     * Metodo que formata um telefone com DDD e DDI
     * @param $value
     * @return string
     */
    public function asPhoneDDD($value, $withLink = true)
    {
        if(Utils::IsNullOrEmpty($value))
            return $this->nullDisplay;

        $lenght = strlen($value);
        $value = preg_replace('/[^A-Za-z0-9]/', '', $value);
        $ddd = '(' . substr($value, 0, 2) . ') ';
        $ddi = '';

        // DDD + 8 Digitos e DDD + 9 Digitos
        if($lenght === 10 || $lenght === 11) {

            $ddd = '(' . substr($value, 0, 2) . ') ';

        // DDI + DDD + 8 Digitos e DDI = DDD + 9 Digitos
        } else if($lenght === 12 || $lenght === 13) {

            $ddi = '+' . substr($value, 0, 2) . ' ';
            $ddd = '(' . substr($value, 2, 2) . ') ';

        }

        $output = $ddi . $ddd . $this->getPhoneText($value);

        if ($withLink === false)
            return $output;

        return Html::a($output, "tel:{$value}", ['title'=>"Ligar para {$output}"]);
    }

    /**
     * Metodo que formata somente telefone
     * @param $value
     * @return string
     */
    public function asPhone($value)
    {
        if($value === null) {
            return $this->nullDisplay;
        }

        $output = $this->getPhoneText($value);

        return Html::a($output, "tel:{$value}", ['title'=>"Ligar para {$output}"]);
    }

    /**
     * Metodo que converte uma decimal do formato BR para US
     * @param float $value
     * @return mixed|string
     */
    public function asDecimalUS($value)
    {
        if (empty($value))
            return null;

        $output = str_replace(".", "", $value);
        return str_replace(",", ".", $output);
    }

    /**
     * Metodo que converte uma data no formato BR para US
     * @param string $value
     * @return string
     */
    public function asDateUS($value)
    {
        if (empty($value))
            return null;

        $explodeData = explode("/", $value);
        return $explodeData[2] . '-' . $explodeData[1] . '-' . $explodeData[0];
    }

    /**
     * Metodo que extrai somente o digitos do telefone, sem DDD e sem DDI
     * @param $value
     * @return string
     */
    private function getPhoneText($value)
    {
        $value = preg_replace('/[^A-Za-z0-9]/', '', $value);
        $length = strlen($value);

        // Telefone 8 Digitos
        if($length === 8) {

            $first = substr($value, 0, 4);
            $last = substr($value, 4, 4);

        // Telefone 9 Digitos
        } else if($length === 9) {

            $first = substr($value, 0, 1) . substr($value, 1, 4);
            $last = substr($value, 5, 4);

        // DDD + 8 Digitos
        } else if($length === 10) {

            $first = substr($value, 2, 4);
            $last = substr($value, 6, 4);

        // DDD + 9 Digitos
        } else if($length === 11) {

            $first = substr($value, 2, 1) . substr($value, 3, 4);
            $last = substr($value, 7, 4);

        // DDI + DDD + 8 Digitos
        } else if($length === 12) {

            $first = substr($value, 4, 4);
            $last = substr($value, 8, 4);

        // DDI + DDD + 9 Digitos
        } else if($length === 13) {

            $first = substr($value, 4, 1) . substr($value, 5, 4);
            $last = substr($value, 9, 4);

        } else {
            throw new RuntimeException('Formato de Telefone inválido.');
        }

        return "{$first}-{$last}";
    }

    /**
     * Remove todos os caracteres não numéricos.
     * @param $string O valor a ser formatado.
     * @return mixed O valor somente com caracteres numéricos.
     */
    public static function removeCharactersNonNumeric($string)
    {
        return preg_replace('/[^0-9]/', '', $string);
    }

    /**
     * Método que formata um valor para o formato CEP.
     * @param string $string O valor a ser formatado.
     * @return string O valor formatado para CEP.
     */
    public static function asCep(string $string):string
    {
        return substr($string, 0, 5) . '-' . substr($string, 5);
    }

    /**
     * Método que formata um valor para o formato CPF.
     * @param string $string O valor a ser formatado.
     * @return string O valor formatado para CPF.
     */
    public static function asCpf(string $string):string
    {
        if (empty($string))
            return '-';

        return substr($string, 0, 3) . '.' . substr($string, 3, 3) . '.' . substr($string, 6, 3) . '-' . substr($string, -2);
    }

    /**
     * Método que formata um valor para o formato CNPJ.
     * @param string $string O valor a ser formatado.
     * @return string O valor formatado para CNPJ.
     */
    public static function asCnpj(string $string):string
    {
        if (empty($string))
            return '-';

        return substr($string, 0, 2) . '.' . substr($string, 2, 3) . '.' . substr($string, 5, 3) . '/' .
            substr($string, 8, 4) . '-' . substr($string, -2);
    }
}