<?php

namespace App\Imports;

use App\Countries;
use App\UserCountries;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class UserCountriesImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $user = Auth::user();
            $cca2 = (!empty($row['cca2']) ? $row['cca2'] : null);
            $cca3 = (!empty($row['cca3']) ? $row['cca3'] : null);
            $country = Countries::where('cca2', $cca2)->orWhere('cca3', $cca3)->first();
            UserCountries::updateOrCreate(
                [
                    'user_uuid'     => $user->uuid,
                    'country_uuid'  => $country->uuid,
                    'country_cca3'  => $country->cca3
                ],
                [
                    //'created_at'     => now(),
                    'updated_at'     => now()
                ]
            );
        }
    }
    
    public function chunkSize(): int
    {
        return 50;
    }
    
}
