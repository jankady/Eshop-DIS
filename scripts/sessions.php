<?php

class SessionClass
{

    public static function checkSessions(): void
    {
        session_start();

        if ($_SESSION["logged_in"] == null || $_SESSION["logged_in"] == false) {
            echo "není nastaveno nebo není přihlašený";
            $_SESSION["logged_in"] = false;

        } else if ($_SESSION["logged_in"] == true) {
            echo "přihlášen";
            $_SESSION["logged_in"] = true;

        }

    }


}