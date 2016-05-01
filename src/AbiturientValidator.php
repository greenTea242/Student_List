<?php

/*Класс обнаружения ошибок*/
class AbiturientValidator {
    private $abiturient;
    private $gateway;

    public function __construct(AbiturientDataGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    /*Добавление нового абитуриента*/
    public function addAbiturient(Abiturient $abiturient)
    {
        $this->abiturient = $abiturient;
    }

    /*Метод создания списка ошибок который потом будет выводиться в шаблоне*/
    public function createErrorsList($abiturientID)
    {
        $errList = [];
        if (($error = $this->checkEmail($abiturientID)) !== TRUE) {
            $errList["email"] = $error;
        }
        if (($error = $this->checkGroupNumber()) !== TRUE) {
            $errList["groupNumber"] = $error;
        }
        if (($error = $this->checkName()) !== TRUE) {
            $errList["name"] = $error;
        }
        if (($error = $this->checkSurname()) !== TRUE) {
            $errList["surname"] = $error;
        }
        if (($error = $this->checkYear()) !== TRUE) {
            $errList["year"] = $error;
        }
        if (($error = $this->checkPoints()) !== TRUE) {
            $errList["points"] = $error;
        }
        if (($error = $this->checkGender()) !== TRUE) {
            $errList["gender"] = $error;
        }
        if (($error = $this->checkLoko()) !== TRUE) {
            $errList["loko"] = $error;
        }
        return $errList;
    }

    /*Метод проверки e-mail*/
    private function checkEmail($abiturientID)
    {
        $email = $this->abiturient->getEmail();
        $regexp = "/{$this->getRegExpForEmail()}/";
        if (!preg_match($regexp, $email)) {
            return "Неправильно введен почтовый ящик!";
        /*Если в базе есть такой уже е-майл у другого студента*/
        /*Второй аргумент $abiturientID исключает при поиске поле e-mail из зарегистрированого студента*/
        } elseif($this->gateway->countEmails($email, $abiturientID) > 0) {
            return "Данный email уже существует!";
        } else {
            return TRUE;
        }
    }

    /*Метод проверки номера группы*/
    private function checkGroupNumber()
    {
        $group = $this->abiturient->getGroupNumber();
        $regexp = "/{$this->getRegExpForGroupNumber()}/u";
        if (!preg_match($regexp, $group)) {
            return "Название группы должно состоять из русских букв и цифр!";
        } elseif (mb_strlen($group) > 5) {
            return "Длина номера группы должна быть меньше 6!";
        } else {
            return TRUE;
        }
    }

    /*Метод проверки имени*/
    private function checkName()
    {
        $name = $this->abiturient->getName();
        $regexp = "/{$this->getRegExpForName()}/u";
        if (!preg_match($regexp, $name)) {
            return "Введите правильное имя! Допустимы русские буквы, \" - \"(дефис) и \" ' \"(апостроф).";
        } else {
            return TRUE;
        }
    }

    /*Метод проверки фамилии*/
    private function checkSurname()
    {
        $name = $this->abiturient->getSurname();
        //Регулярка для имени и фамилии идентична
        $regexp = "/{$this->getRegExpForName()}/u";
        if (!preg_match($regexp, $name)) {
            return "Введите правильную фамилию! Допустимы русские буквы, \" - \"(дефис) и \" ' \"(апостроф).";
        } else {
            return TRUE;
        }
    }

    /*Метод проверки года рождения*/
    private function checkYear()
    {
        $year = $this->abiturient->getYear();
        $regexp = "/{$this->getRegExpForYear()}/";
        if (!preg_match($regexp, $year)) {
            return "Введите корректный год рождения! Пример: 1994.";
        } else {
            return TRUE;
        }
    }

    /*Метод проверки количества очков*/
    private function checkPoints()
    {
        $points = $this->abiturient->getPoints();
        $regexp = "/{$this->getRegExpForPoints()}/u";
        if (!preg_match($regexp, $points)) {
            return "Введите корректное количество баллов! От 0 до 999.";
        } else {
            return TRUE;
        }
    }

    /*Метод проверки пола*/
    private function checkGender()
    {
        if (empty($this->abiturient->getGender())) {
            return "Укажите ваш пол.";
        } else {
            return TRUE;
        }
    }

    /*Метод проверки гесто жительства*/
    private function checkLoko()
    {
        if (empty($this->abiturient->getLoko())) {
            return "Укажите ваше место жительства.";
        } else {
            return TRUE;
        }
    }

    /*Регулярки которые также используются в HTML5 паттернах*/
    public function getRegExpForEmail()
    {
        return '^([\s]*[A-Za-z0-9][\s]*){1,40}@([\s]*[A-Za-z][\s]*){1,13}.([\s]*[A-Za-z][\s]*){1,10}$';
    }

    public function getRegExpForGroupNumber()
    {
        return '^([\s]*[А-Яа-я0-9][\s]*){2,5}$';

    }


    public function getRegExpForName()
    {
        return '^([\s]*[А-Яа-яЁё][\s]*[\'\-]?[\s]*){1,60}$';
    }

    public function getRegExpForYear()
    {
        return '^[\s]*(19|20)[0-9]{2}[\s]*$';
    }

    public function getRegExpForPoints()
    {
        return '^([\s]*[0-9][\s]*){1,3}$';
    }

}