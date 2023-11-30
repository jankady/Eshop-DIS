<?php
class Nav_category {
    public function nav() {
        require_once ("databaseConnect.php");
        $db = new DBconnect();
        $db->connectDB("eshop");
        $querry= "SELECT * FROM value(name)";
        $result = $db->connectDB()->query($querry);
        while ($rows = $result->fetch_array()) {
            echo '<li><a class="dropdown-item" href="#">Actsion</a></li>';

        }
    }
}

?>

