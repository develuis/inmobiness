<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class RouteFile implements ToCollection, WithHeadingRow
{
    protected $rows;

    public function collection(Collection $rows)
    {
        $this->rows = $rows;
    }

    public function getData()
    {
        return $this->rows;
    }
}
