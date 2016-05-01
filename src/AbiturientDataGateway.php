<?php

class AbiturientDataGateway {
    private $pdo;

    public function __construct (PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /*Метод добавления студента в бд*/
    public function addAbiturient(Abiturient $abiturient)
    {
        $query = "INSERT INTO abiturient
                             (name, surname, gender, groupNumber, points, email, year, loko, token)
                              VALUES (:name, :surname, :gender, :groupNumber, :points, :email, :year, :loko, :token)";
        $stmt = $this->pdo->prepare($query);
        /*Добавляем данные одним массивом*/
        $stmt->execute($this->convertAbiturientToArray($abiturient));
        /*Заполняем модель полученным айди и возвращаем ее*/
        $abiturient->setAbiturientID($this->getLastInsertID());
        return $abiturient;
    }

    /*Метод выборки по ID*/
    public function selectAbiturient($abiturientID)
    {
        $query = "SELECT *
                    FROM abiturient
                   WHERE abiturientID=:abiturientID";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":abiturientID", $abiturientID);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Abiturient");
        $abiturient = $stmt->fetch();
        return $abiturient;
    }

    /*Обновление записи в бд*/
    public function updateAbiturient(Abiturient $abiturient)
    {
        $query = "UPDATE abiturient
                     SET name         = :name,
                         surname      = :surname,
                         email        = :email,
                         gender       = :gender,
                         groupNumber  = :groupNumber,
                         points       = :points,
                         year         = :year,
                         loko         = :loko,
                         token        = :token
                   WHERE abiturientID = :abiturientID";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($this->convertAbiturientToArray($abiturient));
    }

    /*Метод превращения объекта с private полями в объект*/
    private function convertAbiturientToArray(Abiturient $abiturient)
    {
        $array = [
            "name"         => $abiturient->getName(),
            "surname"      => $abiturient->getSurname(),
            "email"        => $abiturient->getEmail(),
            "gender"       => $abiturient->getGender(),
            "groupNumber"  => $abiturient->getGroupNumber(),
            "points"       => $abiturient->getPoints(),
            "year"         => $abiturient->getYear(),
            "loko"         => $abiturient->getLoko(),
            "token"        => $abiturient->getToken()
        ];
        /*Если абитуриент зарегистрирован, бд не будет создавать ему новый ID*/
        if ($abiturient->isAbiturientRegistred()) {
            $array["abiturientID"] = $abiturient->getAbiturientID();
        }
        return $array;
    }

    /*Метод проверки оператора сортировки который не дружит с placeholder'ами*/
    private function checkSort($sort)
    {
        $possibleSort = array("name", "surname", "groupNumber", "points");
        $key          = array_search($sort, $possibleSort);
        $sort         = $possibleSort[$key];
        return $sort;
    }

    /*Метод проверки оператора убивания/возрастания который не любит placeholder'ы*/
    private function checkOrder($order)
    {
        $possibleOrder = array("asc", "desc");
        $key           = array_search($order, $possibleOrder);
        $order         = $possibleOrder[$key];
        return $order;
    }

    /*Метод получения последнего добавленго в базу ID*/
    private function getLastInsertID()
    {
        return $this->pdo->lastInsertId();
    }

    /*Метод подсчета количества почтовых ящиков (с определенным именем)*/
    public function countEmails($email, $abiturientID)
    {
        /**
         * Если бы пришло NULL значение, запрос поломался.
         * Меняем на пустую строку(оно придет у незарег-го абитуриента,
         * т.к. поля класса по умолчанию равны NULL)
        */
        if (empty($abiturientID)) {
            $abiturientID = "";
        }
        /*ID нужен чтобы не подсчитать почтовый ящик того же абитуриента, если он существует*/
        $query = "SELECT COUNT(*)
                    FROM abiturient
                   WHERE email=:email AND
                         abiturientID!=:abiturientID";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":email",        $email);
        $stmt->bindValue(":abiturientID", $abiturientID);
        $stmt->execute();
        $counter = $stmt->fetchColumn();
        return $counter;
    }

    /*Метод подсчета количества абитурентов в бд*/
    public function countAbiturients($search)
    {
        /*Если строка запроса не пустая, будет использоваться дополнительный оператор WHERE*/
        if ($search) {
            $searchQuery = $this->createSearchQuery();
            /*Готовим строку для запроса заменяя лишние символы на %*/
            $search = $this->fixSearchString($search);
        } else {
            $searchQuery = "";
        }
        /*Запрос подсчета*/
        $query = "SELECT COUNT(*)
                    FROM abiturient
            $searchQuery";
        $stmt = $this->pdo->prepare($query);
        if (!empty($searchQuery)) {
            $stmt->bindValue(":search", $search);
        }
        $stmt->execute();
        $counter = $stmt->fetchColumn();
        return $counter;
    }

    /*Оператор WHERE иногда используемый в методах countAbiturients и getAbiturientsInPage*/
    private function createSearchQuery()
    {
        return "WHERE CONCAT_WS(' ', name, surname, groupNumber)
                 LIKE :search";
    }

    /*Метод убирание из поисковой строки лишних символов*/
    private function fixSearchString($search)
    {
        /*Меняем в строке поиска пробелы и знаки препинания на знак любого символа в поиске бд*/
        $search = preg_replace("/[^\\w\\d]+/u", "%", $search);
        /*Два процента впереди и в конце должны быть в любом случае*/
        return "%$search%";
    }

    /*Главный метод в котором мы получаем массив абитуриентов из бд на опр-ой странице с опр-ым кол-ом записей*/
    public function getAbiturientsInPage($limit, $offset, $sort, $search, $order)
    {
        /*Если строка запроса не пустая, будет использоваться дополнительный оператор WHERE*/
        if ($search) {
            $searchQuery = $this->createSearchQuery();
            /*Убираем из строки поиска лишние символы*/
            $search = $this->fixSearchString($search);
        } else {
            $searchQuery = "";
        }
        /*Проверяем возможные значения сортировки*/
        $sort  = $this->checkSort($sort);
        $order = $this->checkOrder($order);
        /*Запрос выборки записей с X по Y*/
        $query  = "SELECT *
                     FROM abiturient
             $searchQuery
                    ORDER BY $sort $order
                    LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":limit",  $limit,  PDO::PARAM_INT);
        $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
        if (!empty($searchQuery)) {
            $stmt->bindValue(":search", $search);
        }
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Abiturient');
        $abiturients = $stmt->fetchAll();
        return $abiturients;
    }

    /*Метод проверки существования абитурента с определенным ID и токеном*/
    public function isAbiturientExist($abiturientID, $token)
    {
        $query = "SELECT COUNT(*)
                    FROM abiturient
                   WHERE abiturientID = :abiturientID AND
                         token        = :token";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":abiturientID", $abiturientID);
        $stmt->bindValue(":token",        $token);
        $stmt->execute();
        $counter = $stmt->fetchColumn();
        if ($counter == 1) {;
            return TRUE;
        }
        return FALSE;
    }

    /*Метод проверки существованяи токена*/
    public function isTokenExist($token)
    {
        $query = "SELECT COUNT(*)
                    FROM abiturient
                   WHERE token = :token";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":token", $token);
        $stmt->execute();
        $counter = $stmt->fetchColumn();
        if ($counter == 1) {;
            return TRUE;
        }
        return FALSE;
    }
}

