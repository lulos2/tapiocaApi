<?php

include_once './models/UserModel.php' ;

class AuthHelper{

    public static function isAuthorized() {
        if (isset($_SERVER["PHP_AUTH_USER"],$_SERVER["PHP_AUTH_PW"])) {
            return self::verifyCredentials($_SERVER["PHP_AUTH_USER"],$_SERVER["PHP_AUTH_PW"]);
        }
    }

    private static function verifyCredentials(string $email, string $passwd) : bool {
        $user = (new UserModel())->getUser($email);
        return $user && password_verify($passwd, $user->passwd) && ($user->rol == "admin");
    }

}