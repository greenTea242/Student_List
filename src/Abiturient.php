<?php

class Abiturient
{
    private $name;
    private $surname;
    private $gender;
    private $groupNumber;
    private $points;
    private $email;
    private $year;
    private $loko; /*местный или иногородний*/
    private $token;
    private $abiturientID;

    const GENDER_MALE        = "male";
    const GENDER_FEMALE      = "female";
    const CITY_LOCAL         = "yes";
    const CITY_NONRESIDENT   = "no";

    /**
     * Функционал методов setProperties и setToken не в конструкторе,
     * т.к. база возвращает новые объекты (база не будет пересылать
     * в них переменные)
     */
    /*Метод установки свойств*/
    public function setProperties(array $values)
    {
        foreach ($values as $key => $value) {
            if (property_exists("Abiturient", $key)) {
                $this->$key = $value;
            } else {
                throw new Exception("Submitted unknown property");
            }
        }
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * Универсальный метод проверки зарегистрированности
     * студента (у незарегистированных нет ID)
     */
    public function isAbiturientRegistred()
    {
        if ($this->abiturientID) {
            return true;
        }
        return false;
    }

    public function getAbiturientID()
    {
        return $this->abiturientID;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getGroupNumber()
    {
        return $this->groupNumber;
    }

    public function getPoints()
    {
        return $this->points;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function getLoko()
    {
        return $this->loko;
    }

    public function getToken()
    {
        return $this->token;
    }
}
