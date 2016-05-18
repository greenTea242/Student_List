<?php

/*Класс статических полезных методов*/
class ViewHelper {

    /*Метод корректировки полученных данных из формы регистрации (trim + удаление лишних пробелов между словами*/
    static function fixRegistrationInput ($string)
    {
        return preg_replace("/[\\s]+/", " ", trim(strval($string)));
    }

    /*Метод защиты ссылки*/
    static function getSortedLink($search, $column, $page, $order)
    {
        $link = "index.php?" . http_build_query([
                'search' => $search,
                'sort'   => $column,
                'page'   => $page,
                'order'  => $order
            ]);
        return strval($link);
    }

    /*Метод переключения варианта сортировки*/
    static function changeOrder($order)
    {
        $order = ($order == "desc") ? "asc" : "desc";
        return $order;
    }

    /*Метод обводки найденных слов*/
    static function paintFound($string, $search)
    {
        $string = htmlspecialchars($string, ENT_QUOTES);
        if (empty($search)) {
            return $string;
        }
        /*Делаем из строки, которая будет будущей регуляркой, массив слов*/
        $searchWords = preg_split("/[^\\w'-]+/ui", $search);
        /*Сортируем массив по убыванию значений*/
        usort($searchWords, function($a, $b) {
            return mb_strlen($b) - mb_strlen($a);
        });
        /*Экранируем знаки для будущей регулярки*/
        $searchWords = array_map(function($searchWord) {
            $searchWord = preg_quote($searchWord);
            return $searchWord;
        }, $searchWords);
        $searchWords = implode("|", $searchWords);
        $string = preg_replace("/" . $searchWords . "/ui", "<mark>$0</mark>", $string);
        return $string;
    }

    /*Метод переверота треугольника (sic!)*/
    static function getSymbolForOrder($order)
    {
        if ($order == "asc") {
            /*Возвращаем треугольник*/
            return "[&#9650;]";
        }
        /*Возвращаем перевернутый треугольник*/
        return "[&#9660;]";
    }

    /*Метод выставления атрибута checked в html*/
    static function isInputChecked($genderOfAbiturient, $valueFromInput)
    {
        if (empty($genderOfAbiturient) ||
            strcmp($genderOfAbiturient, $valueFromInput) !== 0) {
            return false;
        }
        return "checked";
    }
}
