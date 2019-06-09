<?php

namespace App\Exports;

use App\UserCountries;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UserCountriesExport implements FromQuery, WithHeadings, ShouldAutoSize
{
    use Exportable;
    
    public function forUser(string $uuid)
    {
        $this->uuid = $uuid;
        
        return $this;
    }
	
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return UserCountries::query()->where('user_uuid', $this->uuid);
    }
	
    public function headings(): array
    {
        return [
            'uuid',         // A
            'user_uuid',    // B
            'country_uuid', // C
            'cca3',         // D
        ];
    }

}
