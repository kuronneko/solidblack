<?php

namespace App\Imports;

use App\Models\Logger;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;

class LoggersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Logger([
            'id'     => $row['id'],
            'user_id'    => Auth::user()->id,
            'ip'    => $row['ip'],
            'country'    => $row['country'],
            'city'    => $row['city'],
            'browser'    => $row['browser'],
            'browser_version'    => $row['browser_version'],
            'platform'    => $row['platform'],
            'platform_version'    => $row['platform_version'],
            'agent'    => $row['agent'],
            'host'    => $row['host'],
            'created_at'    => $row['created_at'],
            'updated_at'    => $row['updated_at'],
        ]);

/*         return new Logger([
            'id'     => $row[0],
            'user_id'    => $row[1],
            'ip'    => $row[2],
            'country'    => $row[3],
            'city'    => $row[4],
            'browser'    => $row[5],
            'browser_version'    => $row[6],
            'platform'    => $row[7],
            'platform_version'    => $row[8],
            'agent'    => $row[9],
            'host'    => $row[10],
            'created_at'    => $row[11],
            'updated_at'    => $row[12],
        ]); */
    }
}
