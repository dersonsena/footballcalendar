<?php

namespace app\components;

class Utils
{
    /**
     * Metodo que converte um valor dados em bytes para: KB, MB ou GB
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    public static function getHumanFileSize($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        for($i=1; $i<=$pow; $i++)
            $bytes /= 1000;

        return number_format(round($bytes, $precision), 2, ',', '') .' ' . $units[$pow];
    }

    /**
     * Metodo que retorna o ultimo dia do mes passado.
     * @param string $monthYear Mes e ano no formato MM/YYYY
     * @return mixed
     */
    public static function getLastDayOfMonth($monthYear)
    {
        $exp = explode('/', $monthYear);
        return date('t', strtotime("$exp[1]-{$exp[0]}-01"));
    }

    /**
     * Metodo que verifica se uma variavel e NULA e vazia
     * @param mixed $var
     * @return bool
     */
    public static function IsNullOrEmpty($var)
    {
        return is_null($var) || $var === '';
    }

    /**
     * Retira a acentuação e caracteres especiais de uma string
     * @param string $string A string a ser "sanitizada"
     * @return string A string "sanitizada"
     */
    public static function transliterate($string) {

        $specialCharacters = array(
            '/[ÂÀÁÄÃ]/' => 'A',
            '/[âãàáä]/' => 'a',
            '/[ÊÈÉË]/' => 'E',
            '/[êèéë]/' => 'e',
            '/[ÎÍÌÏ]/' => 'I',
            '/[îíìï]/' => 'i',
            '/[ÔÕÒÓÖ]/' => 'O',
            '/[ôõòóö]/' => 'o',
            '/[ÛÙÚÜ]/' => 'U',
            '/[ûúùü]/' => 'u',
            '/ç/' => 'c',
            '/Ç/' => 'C',
            '/ /' => '',
            '/[_.()\/-]/' => ''
        );

        $transliterated = preg_replace(
            array_keys($specialCharacters), array_values($specialCharacters), $string
        );

        return $transliterated;
    }

    /**
     *  Metodo que pega as informacoes do navegador e sistema operacional do cliente
     * @return array Matriz com as informacoes
     */
    public static function getUserAgentInfo()
    {
        $useragent = $_SERVER['HTTP_USER_AGENT'];

        // Pegando informacoes do navegador
        if (preg_match('|MSIE ([0-9].[0-9]{1,2})|', $useragent, $matched)) {
            $browser_version = $matched[1];
            $browser = 'IE';
        } else if (preg_match('|Opera/([0-9].[0-9]{1,2})|', $useragent, $matched)) {
            $browser_version = $matched[1];
            $browser = 'Opera';
        } else if (preg_match('|Firefox/([0-9\.]+)|', $useragent, $matched)) {
            $browser_version = $matched[1];
            $browser = 'Firefox';
        } else if (preg_match('|Chrome/([0-9\.]+)|', $useragent, $matched)) {
            $browser_version = $matched[1];
            $browser = 'Chrome';
        } else if (preg_match('|Safari/([0-9\.]+)|', $useragent, $matched)) {
            $browser_version = $matched[1];
            $browser = 'Safari';
        } else {
            $browser_version = 0;
            $browser = 'Outro';
        }

        // Pegando informacoes do OS
        if (preg_match('|Mac|', $useragent, $matched)) {
            $so = 'MAC';
        } else if (preg_match('|Windows|', $useragent, $matched) || preg_match('|WinNT|', $useragent, $matched) || preg_match('|Win95|', $useragent, $matched)) {
            $so = 'Windows';
        } else if (preg_match('|Linux|', $useragent, $matched)) {
            $so = 'Linux';
        } else {
            $so = 'Outro';
        }

        return array(
            'browser' => $browser,
            'version' => $browser_version,
            'so' => $so,
            'user_agent' => $useragent
        );
    }
}