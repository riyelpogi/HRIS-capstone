<?php

namespace App\Imports;

use App\Models\InandOut;
use Maatwebsite\Excel\Concerns\ToModel;

class EmployeeInandOut implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new InandOut([
            'employee_id' => $row[0],
            'year' => $row[1],
            'month' => $row[2],
            'date' => $row[3],
            'time' => $row[4],
            'inorout' => $row[5],
        ]);
    }
}
