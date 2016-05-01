<?php

class Pager {
    private $totalPages;
    private $recordsPerPage;
    private $link;

    public function __construct($totalPages, $recordsPerPage, $link)
    {
        $this->totalPages     = $totalPages;
        $this->recordsPerPage = $recordsPerPage;
        $this->link           = $link;
    }

    public function getTotalPages()
    {
        return $this->totalPages;
    }

    /*Метод поиска номера записи бд с которой будет создаваться список*/
    public function getOffsetForDB($page)
    {
        $offset = ($page - 1) * $this->recordsPerPage;
        return $offset;
    }

    public function getLinkForPage($number)
    {
        $link = str_replace("{page}", $number, $this->link);
        return $link;
    }

    public function getLinkForLastPage()
    {
        return $this->getLinkForPage($this->totalPages);
    }

    /*Метод проверки возможных значений для страницы*/
    public function checkPossiblePages ($page)
    {
        if (is_numeric($page) &&
            $page >= 1        &&
            $page <=  $this->totalPages
        ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}