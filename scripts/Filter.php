<?php

class Filters
{
    public function filter_query($price, $availability, $sale, $manafacturer,)
    {
        // Vytvoří SQL dotaz
        $query = 'SELECT id FROM product WHERE';

        if ($price !== '') {
            $query .= ' price BETWEEN min_price AND max_price';
        }

        if ($availability !== '') {
            if ($query !== 'SELECT id FROM product WHERE') {
                $query .= ' AND';
            }
            $query .= ' number_of_products > 0';
        }

        if ($sale !== '') {
            if ($query !== 'SELECT id FROM product WHERE') {
                $query .= ' AND';
            }
            $query .= ' ID_sale = sale';
        }

        if ($manafacturer !== '') {
            if ($query !== 'SELECT id FROM product WHERE') {
                $query .= ' AND';
            }
            $query .= ' ID_manafacturer IN (manafacturer)';
        }

        // Vraťte SQL dotaz
        return $query;
    }

    public function process()
    {
        if (isset($_GET['submit'])) {
            //bind parameters
            if (isset($_GET["min-price"])) {
                $min_price = $_GET["min-price"];
                echo $min_price;
            }
            if (isset($_GET["max-price"])) {
                $max_price = $_GET["max-price"];
                echo $max_price;
            }
            if (isset($_GET["availability"])) {
                $availability = $_GET["availability"];
                echo $availability;
            }
            if (isset($_GET["sale"])) {
                $sale = $_GET["sale"];
                echo $sale;
            }
            if (isset($_GET["manufacturers"])) {
                $selected_manufacturers = $_GET['manufacturers'] ?? array();
                $manufacturers_string = implode(',', $selected_manufacturers);
echo $manufacturers_string;
            }
            if (isset($_GET["categories"])) {
                $selected_categories = $_GET['categories'] ?? array();
                $categories_string = implode(',', $selected_categories);
                echo $categories_string;
            }
            // Redirect back to the page with SQL querry
//            header('Location: product.php');
            exit;
        }
    }

    public function clearFilter()
    {
        // Check if the "clear_filters" button was clicked
        if (isset($_GET['clear_filters'])) {
            // Redirect back to the page without any filter parameters
            header('Location: product.php');
            exit;
        }
    }
}


$filter = new Filters();
$filter->clearFilter();
$filter->process();