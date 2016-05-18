<?php

class Pager {
    private $numberOfAbiturients; /*количество абитуриентов*/
    private $recordsPerPage;      /*желаемое количество записей на странице*/
    private $link;                /*образец ссылки*/

    public function __construct($numberOfAbiturients, $recordsPerPage, $link)
    {
        $this->numberOfAbiturients = $numberOfAbiturients;
        $this->recordsPerPage      = $recordsPerPage;
        $this->link                = $link;
    }

    /*Метод подсчета необходимого количества страниц*/
    public function getTotalPages()
    {
        return ceil($this->numberOfAbiturients/$this->recordsPerPage);
    }

    /*Метод поиска номера записи бд с которой будет создаваться список*/
    public function getOffsetForDB($page)
    {
        $offset = ($page - 1) * $this->recordsPerPage;
        return $offset;
    }

    /*Метод получения ссылки для конкретной страницы*/
    public function getLinkForPage($number)
    {
        $link = str_replace("{page}", $number, $this->link);
        return $link;
    }

    /*Метод получения ссылки для последней страницы*/
    public function getLinkForLastPage()
    {
        return $this->getLinkForPage($this->getTotalPages());
    }

    /*Метод проверки возможных значений для страницы*/
    public function checkPossiblePages ($page)
    {
        if (is_numeric($page) &&
            $page >= 1        &&
            $page <=  $this->getTotalPages()
        ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /*Метод получения списка доступных для навигации страниц*/
    public function getListOfVisiblePages($myPage)
    {
        $visiblePages = [];
        for ($page = $myPage - 2; $page <= $myPage + 2; $page++) {
            if ($this->checkPossiblePages($page)) {
                $visiblePages[] = $page;
            }
        }
        return $visiblePages;
    }
}
