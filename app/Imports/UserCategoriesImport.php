<?php

namespace App\Imports;

use App\Categories;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class UserCategoriesImport implements ToCollection, WithHeadingRow, WithChunkReading
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
            $name = (!empty($row['name']) ? $row['name'] : null);
            $icon = (!empty($row['icon']) ? $row['icon'] : 'folder');
            $color = (!empty($row['color']) ? $row['color'] : 'blue');
            $desc = (!empty($row['description']) ? $row['description'] : null);
            Categories::updateOrCreate(
                [
                    'user_uuid'	=> $user->uuid,
                    'name'	=> $name,
                ],
                [
                    'description'	=> $desc,
                    'icon'	=> $icon,
                    'color'	=> $color,
                    //'created_at'    => now(),
                    //'updated_at'    => now(),
                    //'deleted_at'    => now(),
            ]);
        }
    }
    
    public function chunkSize(): int
    {
        return 50;
    }
    
}
