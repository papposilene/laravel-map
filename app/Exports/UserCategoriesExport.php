<?php

namespace App\Exports;

use App\Categories;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UserCategoriesExport implements FromQuery, WithHeadings, ShouldAutoSize
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
        return Categories::query()->where('user_uuid', $this->uuid);
    }
	
    public function headings(): array
    {
        return [
            'uuid',         // A
            'name',         // B
            'description',  // C
            'icon',         // D
            'color',        // E
            'user_uuid'     // F
        ];
    }

}
