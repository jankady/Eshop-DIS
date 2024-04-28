<?php

class SessionClass
{

    public static function checkSessions(): void
    {
        session_start();

        // Kontrola, zda je session inicializována
        if (!isset($_SESSION["logged_in"])) {
            echo "Session není inicializována nebo uživatel není přihlášený.";
            $_SESSION["logged_in"] = false;
        } elseif ($_SESSION["logged_in"] == true) {
            echo "Uživatel je přihlášen.";
            $_SESSION["logged_in"] = true;
        } else {
            echo "Uživatel není přihlášený.";
            $_SESSION["logged_in"] = false;
        }

    }
}

?>