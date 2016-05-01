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
        $search = htmlspecialchars($search, ENT_QUOTES);
        /*Если строка запроса состоит из нескольких слов, мы должны проверить каждое*/
        $searchWords = preg_split("/[^\\w]+/ui", $search);
        /*Сортируем массив по убыванию значений*/
        usort($searchWords, function($a, $b) {
            return mb_strlen($b) - mb_strlen($a);
        });
        /*Попытка через анонимную функцию*/
        /**
        $searchWords = array_map(function($search) {
            $v = "/" . preg_quote($search) . "/ui";
            return $search;
        }, $searchWords);
        $string = preg_replace_callback($searchWords, function (array $matches) {
            var_dump($matches);
            return "<mark>$matches[0]</mark>";
        }, $string);
         */
        /**
         * С таблицей будем работать как с поисковой строкой  - мы
         * будем проверять каждое слово по отдельности.
         * Знаков препинания там быть не может в отличие от поисковой строки,
         * поэтому explode с пробелом, а не preg_split со знаками.
         */
        $words = explode(" ", $string);
        foreach ($words as &$word) {
            foreach ($searchWords as $search) {
                if (mb_strripos($word, $search) !== false) {
                    if (preg_match("<mark>", $word)) {
                        continue;
                    }
                    $word = preg_replace("/" . preg_quote($search) . "/ui", "<mark>$0</mark>", $word);
                }
            }
        }
        $string = implode(" ", $words);
        return $string;
    }
}