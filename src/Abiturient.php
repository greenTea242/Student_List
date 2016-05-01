<?php

class Abiturient
{
    private $name;
    private $surname;
    private $gender;
    private $groupNumber;
    private $points;
    private $email;
    private $year; /*год*/
    private $loko; /*местный или иногородний*/

    const GENDER_MALE        = "male";
    const GENDER_FEMALE      = "female";
    const CITY_LOCAL         = "yes";
    const CITY_NONRESIDENT   = "no";

    public function setFields(array $values)
    {
        foreach ($values as $key => $value) {
            $this->$key = $value;
        }
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
}
