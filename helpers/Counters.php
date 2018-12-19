<?php

namespace helpers;

/**
 * Class Counters
 * @package helpers
 */
class Counters
{
    /**
     * @param bool $isUTF8
     * @return mixed|string
     */
    public static function getCounters($isUTF8 = false)
    {

        if (file_exists($file = $_SERVER['DOCUMENT_ROOT'] . "/counters/all.php")) {

            $counters = include $file;

            return $isUTF8
                ? iconv("windows-1251", "UTF-8", $counters)
                : $counters;
        }

        return '';

    }
}