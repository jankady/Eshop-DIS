<?php

class Filters
{
   public function filter_query($price, $availability, $sale, $manafacturer,)
    {
        // Vytvoří SQL dotaz
        $query = 'SELECT id FROM product WHERE';

        if ($price !== '') {
            $query .= ' price BETWEEN min_price_query AND max_price_query';
        }

        if ($availability !== '') {
            if ($query !== 'SELECT id FROM product WHERE') {
                $query .= ' AND';
            }
            $query .= ' number_of_products = availability_query';
        }

        if ($sale !== '') {
            if ($query !== 'SELECT id FROM product WHERE') {
                $query .= ' AND';
            }
            $query .= ' ID_sale = sale_query';
        }

        if ($manafacturer !== '') {
            if ($query !== 'SELECT id FROM product WHERE') {
                $query .= ' AND';
            }
            $query .= ' ID_manafacturer = $manafacturer_query';
        }

        // Vraťte SQL dotaz
        return $query;
    }
}