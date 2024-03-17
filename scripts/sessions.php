<?php
class SessionClass {

    public static function checkSessions(): void
    {
        session_start();

        $_SESSION["logged_in"]=false;

        if (false) {
            // setup loggin
            $_SESSION["logged_in"]=true;

        }
        else {
            echo "nejsi přihlašený";
        }

    }


}