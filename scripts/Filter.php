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

    public function process() {

    }
}
