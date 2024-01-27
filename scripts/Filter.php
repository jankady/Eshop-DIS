<?php
class Filters
{
    public function getPrice()
    {
        if (isset($_GET['price'])) {
            return $_GET['price'];
        } else {
            return null;
        }
    }

    public function getManufacturer()
    {
        if (isset($_GET['manufacturer'])) {
            return $_GET['manufacturer'];
        } else {
            return null;
        }
    }

    public function getOrder()
    {
        if (isset($_GET['order'])) {
            return $_GET['order'];
        } else {
            return 'asc';
        }
    }
}