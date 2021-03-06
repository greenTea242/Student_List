<?php

/*Класс обнаружения ошибок*/
class AbiturientValidator {
    private $gateway;

    public function __construct(AbiturientDataGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    /*Метод создания списка ошибок которые потом будут выводиться в шаблоне*/
    public function createErrorsList(Abiturient $abiturient)
    {
        $properties = [
            "email",
            "groupNumber",
            "name",
            "surname",
            "year",
            "points",
            "gender",
            "loko"
        ];
        $errList = [];
        foreach ($properties as $property) {
            $method = "check" . ucfirst($property);
            $error = $this->$method($abiturient);
            if ($error !== TRUE) {
                $errList[$property] = $error;
            }
        }
        return $errList;
    }

    /*Метод проверки e-mail*/
    private function checkEmail(Abiturient $abiturient)
    {
        $email        = $abiturient->getEmail();
        $abiturientID = $abiturient->getAbiturientID();
        $regexp       = $this->getPHPRegExpForEmail();
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
    private function checkGroupNumber(Abiturient $abiturient)
    {
        $group  = $abiturient->getGroupNumber();
        $regexp = $this->getPHPRegExpForGroupNumber();
        if (!preg_match($regexp, $group)) {
            return "Название группы должно состоять из русских букв и цифр!";
        } elseif (mb_strlen($group) > 5) {
            return "Длина номера группы должна быть меньше 6!";
        } else {
            return TRUE;
        }
    }

    /*Метод проверки имени*/
    private function checkName(Abiturient $abiturient)
    {
        $name = $abiturient->getName();
        $regexp = $this->getPHPRegExpForName();
        if (!preg_match($regexp, $name)) {
            return "Введите правильное имя! Допустимы русские буквы, \" - \"(дефис) и \" ' \"(апостроф).";
        } else {
            return TRUE;
        }
    }

    /*Метод проверки фамилии*/
    private function checkSurname(Abiturient $abiturient)
    {
        $name = $abiturient->getSurname();
        /*Регулярка для имени и фамилии идентична*/
        $regexp = $this->getPHPRegExpForName();
        if (!preg_match($regexp, $name)) {
            return "Введите правильную фамилию! Допустимы русские буквы, \" - \"(дефис) и \" ' \"(апостроф).";
        } else {
            return TRUE;
        }
    }

    /*Метод проверки года рождения*/
    private function checkYear(Abiturient $abiturient)
    {
        $year = $abiturient->getYear();
        $regexp = $this->getPHPRegExpForYear();
        if (!preg_match($regexp, $year)) {
            return "Введите корректный год рождения! Пример: 1994.";
        } else {
            return TRUE;
        }
    }

    /*Метод проверки количества очков*/
    private function checkPoints(Abiturient $abiturient)
    {
        $points = $abiturient->getPoints();
        $regexp = $this->getPHPRegExpForPoints();
        if (!preg_match($regexp, $points)) {
            return "Введите корректное количество баллов! От 0 до 999.";
        } else {
            return TRUE;
        }
    }

    /*Метод проверки пола*/
    private function checkGender(Abiturient $abiturient)
    {
        if (empty($abiturient->getGender())) {
            return "Укажите ваш пол.";
        } else {
            return TRUE;
        }
    }

    /*Метод проверки места жительства*/
    private function checkLoko(Abiturient $abiturient)
    {
        if (empty($abiturient->getLoko())) {
            return "Укажите ваше место жительства.";
        } else {
            return TRUE;
        }
    }

    /*Регулярки для языка PHP*/
    public function getPHPRegExpForEmail()
    {
        return "/^([\\s]*[A-Za-z0-9][\\s]*){1,40}@([\\s]*[A-Za-z][\\s]*){1,13}.([\\s]*[A-Za-z][\\s]*){1,10}$/";
    }

    public function getPHPRegExpForGroupNumber()
    {
        return "/^([\\s]*[А-Яа-яЕё0-9][\\s]*){2,5}$/u";

    }

    public function getPHPRegExpForName()
    {
        return "/^([\\s]*[А-Яа-яЁё][\\s]*['-]?[\\s]*){1,60}$/u";
    }

    public function getPHPRegExpForYear()
    {
        return "/^[\\s]*(19|20)[0-9]{2}[\\s]*$/";
    }

    public function getPHPRegExpForPoints()
    {
        return "/^([\\s]*[0-9][\\s]*){1,3}$/";
    }

    /*Регулярки для HTML5*/
    public function getHTML5RegExpForEmail()
    {
        return "^([\\s]*[A-Za-z0-9][\\s]*){1,40}@([\\s]*[A-Za-z][\\s]*){1,13}.([\\s]*[A-Za-z][\\s]*){1,10}$";
    }

    public function getHTML5RegExpForGroupNumber()
    {
        return "^([\\s]*[А-Яа-яЕё0-9][\\s]*){2,5}$";
    }

    public function getHTML5RegExpForName()
    {
        return "^([\\s]*[А-Яа-яЁё][\\s]*['-]?[\\s]*){1,60}$";
    }

    public function getHTML5RegExpForYear()
    {
        return "^[\\s]*(19|20)[0-9]{2}[\\s]*$";
    }

    public function getHTML5RegExpForPoints()
    {
        return "^([\\s]*[0-9][\\s]*){1,3}$";
    }
}