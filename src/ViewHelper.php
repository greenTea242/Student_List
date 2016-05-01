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
    static function paintFound($word, $search)
    {
        $word   = htmlspecialchars($word, ENT_QUOTES);
        $search = htmlspecialchars($search, ENT_QUOTES);
        /*Если строка запроса состоит из нескольких слов, мы должны проверить каждое*/
        $searchWords = explode(" ", $search);
        /*Сортируем массив по убыванию значений*/
        usort($searchWords, function($a, $b) {
            return mb_strlen($b) - mb_strlen($a);
        });
        foreach ($searchWords as $search) {
            if (mb_strripos($word, $search) !== false) {
                $word = preg_replace("/" . preg_quote($search) . "/ui", "<mark>$0</mark>", $word);
                break;
            }
        }
        return $word;
    }
}