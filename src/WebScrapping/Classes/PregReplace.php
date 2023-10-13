<?php

namespace Chuva\Php\WebScrapping\Classes;

class PregReplace {

    public static function removeSpace(string|array $data) {

        if(gettype($data) === "array") {

            $newArray = array_map(function ($text) {
                return ["author" => trim(preg_replace('/\s+/', ' ',$text))];
            }, $data);

            return $newArray;
        }

        return trim(preg_replace('/\s+/', ' ',$data));
    }

    public static function onlyNumbers(string $data) {
        return preg_replace('/[^0-9]/', '', $data);
    }

    public static function onlyWords(string $data) {
        return preg_replace('/[^A-Za-z]/', ' ', $data);
    }
}