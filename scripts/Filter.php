<?php

class Filters
{
    // Prepare SQL querry for filtering, depends on information provided in form in product.php
    public function filter_query($min_price, $max_price, $availability, $sale, $manafacturer, $category)
    {
        // create default SQL
        $query = 'SELECT product.*, sale.discount_percent AS discount  FROM product
                    INNER JOIN sale ON product.ID_sale=sale.ID WHERE';

        if ($min_price !== 0 && $max_price !== 0) {
            $query .= ' price BETWEEN ' . $min_price . ' AND ' . $max_price;
        } else if ($min_price !== 0 && $max_price === 0) {
            $query .= ' price BETWEEN ' . $min_price . ' AND (SELECT MAX(price) FROM product)';
        } else if ($min_price === 0 && $max_price !== 0) {
            $query .= ' price BETWEEN 0 AND ' . $max_price;
        }


        if ($availability !== '') {
            if ($query !== 'SELECT product.*, sale.discount_percent AS discount  FROM product
                    INNER JOIN sale ON product.ID_sale=sale.ID WHERE') {
                $query .= ' AND';
            }
            $query .= ' number_of_products > 0';
        }

        if ($sale !== '') {
            if ($query !== 'SELECT product.*, sale.discount_percent AS discount  FROM product
                    INNER JOIN sale ON product.ID_sale=sale.ID WHERE') {
                $query .= ' AND';
            }
            $query .= ' ID_sale > 1';
        }

        if ($manafacturer !== '') {
            if ($query !== 'SELECT product.*, sale.discount_percent AS discount  FROM product
                    INNER JOIN sale ON product.ID_sale=sale.ID WHERE') {
                $query .= ' AND';
            }
            $query .= ' ID_manafacturer IN (' . $manafacturer . ')';
        }
        if ($category !== '') {
            if ($query !== 'SELECT product.*, sale.discount_percent AS discount  FROM product
                    INNER JOIN sale ON product.ID_sale=sale.ID WHERE') {
                $query .= ' AND';
            }
            $query .= ' ID_category IN (' . $category . ')';
        }

//if none filter is selected remove WHERE
        if ($query == 'SELECT product.*, sale.discount_percent AS discount  FROM product
                    INNER JOIN sale ON product.ID_sale=sale.ID WHERE') $query = 'SELECT product.*, sale.discount_percent AS discount  FROM product
                    INNER JOIN sale ON product.ID_sale=sale.ID';

//        $currentPage = ($_GET['page']-1) *6; // změnit 6 na 30 jinak se zobrazuje 6 produktu
//        $query.= ' LIMIT 6 OFFSET '.$currentPage;   // změnit 6 na 30 jinak se zobrazuje 6 produktu
        // return SQL querry
        return $query;
    }

    public function process()
    {
        //binds provided parameters into variables
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
            // create array if there are more parameters selected
            if (isset($_GET["manufacturers"])) {
                $selected_manufacturers = $_GET['manufacturers'] ?? array();
                $manufacturers_string = implode(',', $selected_manufacturers);
            } else $manufacturers_string = '';
            if (isset($_GET["categories"])) {
                $selected_categories = $_GET['categories'] ?? array();
                $categories_string = implode(',', $selected_categories);
            } else $categories_string = '';

            //return full sql querry into product.php
            $sql = ($this->filter_query($min_price, $max_price, $availability, $sale, $manufacturers_string, $categories_string));
            return $sql;

        }
    }

    //create filters, is called when button is clicked
    public function clearFilter()
    {
        // Check if the "clear_filters" button was clicked
        if (isset($_GET['clear_filters'])) {
            // Redirect back to the page without any filter parameters
            header('Location: product.php?page=1&sort_by=1');
            exit;
        }
    }
}

// needs to be there, serve for calling the method
$filter = new Filters();
$filter->clearFilter();
