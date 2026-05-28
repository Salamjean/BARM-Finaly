<?php

namespace App\Excel;

use Maatwebsite\Excel\Concerns\ToArray;

class ImportAdherent implements ToArray
{
    public function array(array $array)
    {
        return $array;
    }
}
