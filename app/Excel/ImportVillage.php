<?php

namespace App\Excel;

use Maatwebsite\Excel\Concerns\ToArray;

class ImportVillage implements ToArray
{
    public function array(array $array)
    {
        return $array;
    }
}
