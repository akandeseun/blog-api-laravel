<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{

    use Importable;
    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
        // $testArr = [];
        // foreach ($collection as $row) {
        //     array_push($testArr, $row);
        // }

        // collect($testArr);

        // return new \App\Models\User([
        //     'name' => $row[0],
        //     'name' => $row[0],
        //     'name' => $row[0],
        // ]);
    }
}
