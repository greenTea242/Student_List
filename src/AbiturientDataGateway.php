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
                             (name, surname, gender, groupNumber, points, email, year, loko)
                              VALUES (:name, :surname, :gender, :groupNumber, :points, :email, :year, :loko)";
        $stmt = $this->pdo->prepare($query);
        /*Добавляем данные одним массивом*/
        $stmt->execute($this->convertAbiturientToArray($abiturient));
    }

    /*Метод выборки по ID*/
    public function selectAbiturient($abiturientID)
    {
        /*Запрос выборки*/
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
    public function updateAbiturient(Abiturient $abiturient, $abiturientID)
    {
        $query = "UPDATE abiturient
                     SET name         = :name,
                         surname      = :surname,
                         email        = :email,
                         gender       = :gender,
                         groupNumber  = :groupNumber,
                         points       = :points,
                         year         = :year,
                         loko         = :loko
                   WHERE abiturientID = $abiturientID";
        /*$abiturientID уже проверялось в контроллере register.php методом checkCookie()*/
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
            "loko"         => $abiturient->getLoko()
        ];
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

    /*Метод проверки cookie*/
    public function isAbiturientIDExist($abiturientID)
    {
        $query = "SELECT COUNT(*)
                    FROM abiturient
                   WHERE abiturientID = :abiturientID";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":abiturientID", $abiturientID);
        $stmt->execute();
        $counter = $stmt->fetchColumn();
        if ($counter == 1) {;
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /*Метод получения последнего добавленго в базу ID*/
    public function getLastInsertID()
    {
        return $this->pdo->lastInsertId();
    }

    /*Метод подсчета количества почтовых ящиков (с определенным именем)*/
    public function countEmails($email, $abiturientID)
    {
        /*ID нужен чтобы не считать почтовый ящик, если он существует, того же абитуриента*/
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
        if ($search != NULL) {
            $searchQuery = $this->createSearchQuery();
            $search = "%$search%";
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

    /*Главный метод в котором мы получаем массив абитуриентов из бд на опр-ой странице с опр-ым кол-ом записей*/
    public function getAbiturientsInPage($limit, $offset, $sort, $search, $order)
    {
        /*Если строка запроса не пустая, будет использоваться дополнительный оператор WHERE*/
        if ($search != NULL) {
            $searchQuery = $this->createSearchQuery();
            $search = "%$search%";
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
        $stmt   = $this->pdo->prepare($query);
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
}

