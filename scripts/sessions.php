<?php
class SessionClass {

    public static function checkSessions() {
        session_start();

        $_SESSION["logged_in"]=false;

        if (false) {
            // setup loggin
            $_SESSION["logged_in"]=true;

        }

    }

    public function cartSession() {
        if (isset($_POST['submit_addToCart'])) {
            session_start();
            echo "ahoj";

        }

    }
}