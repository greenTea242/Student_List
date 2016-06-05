<?php

/*Класс работы с cookie*/
class Authorization {
    private $gateway;
    private $tokenHelper;

    public function __construct(AbiturientDataGateway $gateway, TokenHelper $tokenHelper)
    {
        $this->gateway     = $gateway;
        $this->tokenHelper = $tokenHelper;
    }

    public function getAbiturient($authToken)
    {
        if ($this->checkCookie($authToken)) {
            $this->logIn($authToken);
            return $this->gateway->selectAbiturient($authToken);
        } else {
            /**
             * Если токена нет(студент первый раз) или токен присутсвует в бд(авторизация
             * до этого момента была провалена, поэтому скорее всего
             * пользователь - злоумышленник(подделывает другим имена и баллы, бессовестный!)).
             * В последнем случае его надо заново создать, иначе будет повтор токенов в бд
             */
            $authToken = $this->tokenHelper->createToken();
            $this->logIn($authToken);
            return new Abiturient();
        }
    }

    public function logIn($authToken)
    {
        setcookie("authToken", $authToken, time() + (10 * 365 * 24 * 60 * 60), "", "", "", 1);
    }

    public function checkCookie($authToken)
    {
        if (empty($authToken)        ||
            !$this->gateway->isAbiturientExist($authToken)) {
            return false;
        }
        return true;
    }

    /*Метод удаления куки*/
    public function logOut()
    {
        setcookie("authToken",  "", time() - 3600);
    }

}
