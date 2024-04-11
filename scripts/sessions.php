<?php
class SessionClass {

    public static function checkSessions(): void
    {
        session_start();


        if ($_SESSION["logged_in"]==true) {
        echo "přihlášen";
        $_SESSION["logged_in"]=true;

    }
        else {
            echo "není přihlášen";
            $_SESSION["logged_in"]=false;
        }

    }


}