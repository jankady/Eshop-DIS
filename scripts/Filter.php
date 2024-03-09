<?php

class Filters
{
    public function filter_query($min_price, $max_price, $availability, $sale, $manafacturer, $category)
    {
        // Vytvoří SQL dotaz
        $query = 'SELECT id FROM product WHERE';

        if ($min_price !== 0 && $max_price !== 0) {
            $query .= ' price BETWEEN ' . $min_price . ' AND ' . $max_price;
        } else if ($min_price !== 0 && $max_price === 0) {
            $query .= ' price BETWEEN ' . $min_price . ' AND (SELECT MAX(price) FROM product)';
        } else if ($min_price === 0 && $max_price !== 0) {
            $query .= ' price BETWEEN 0 AND ' . $max_price;
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
            $query .= ' ID_sale > 1';
        }

        if ($manafacturer !== '') {
            if ($query !== 'SELECT id FROM product WHERE') {
                $query .= ' AND';
            }
            $query .= ' ID_manafacturer IN (' . $manafacturer . ')';
        }
        if ($category !== '') {
            if ($query !== 'SELECT id FROM product WHERE') {
                $query .= ' AND';
            }
            $query .= ' ID_category IN (' . $category . ')';
        }


        if ($query == 'SELECT id FROM product WHERE') $query = 'SELECT id FROM product';


        // return SQL querry
        return $query;
    }

    public function process()
    {
        if (isset($_GET['submit'])) {
            //bind parameters
            if (isset($_GET["min-price"])) {
                $min_price = intval($_GET["min-price"]);
            } else $min_price = '';
            if (isset($_GET["max-price"])) {
                $max_price = intval($_GET["max-price"]);
            } else $max_price = '';
            if (isset($_GET["availability"])) {
                $availability = $_GET["availability"];
            } else $availability = '';
            if (isset($_GET["sale"])) {
                $sale = $_GET["sale"];
            } else $sale = '';
            if (isset($_GET["manufacturers"])) {
                $selected_manufacturers = $_GET['manufacturers'] ?? array();
                $manufacturers_string = implode(',', $selected_manufacturers);
            } else $manufacturers_string = '';
            if (isset($_GET["categories"])) {
                $selected_categories = $_GET['categories'] ?? array();
                $categories_string = implode(',', $selected_categories);
            } else $categories_string = '';

            echo $this->filter_query($min_price, $max_price, $availability, $sale, $manufacturers_string, $categories_string);

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