<?php

namespace App\Exports;

use App\Addresses;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UserAddressesExport implements FromQuery, WithHeadings, ShouldAutoSize
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
        return Addresses::query()->where('user_uuid', $this->uuid);
    }
	
    public function headings(): array
    {
        return [
            'uuid',             // A
            'name',             // B
            'owner',            // C
            'address',          // D
            'description',      // E
            'url',              // F
            'phone',            // G
            'latlng',           // H
            'user_uuid',        // I
            'category_uuid',    // J
            'country_uuid',     // K
            'place_id'          // L
        ];
    }

}
