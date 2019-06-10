<?php

namespace App\Imports;

use App\Addresses;
use App\Categories;
use App\Countries;
use App\UserCountries;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class UserAddressesImport implements ToCollection, WithHeadingRow, WithChunkReading
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
            $name           = (!empty($row['name']) ? $row['name'] : null);
            $owner          = (!empty($row['owner']) ? $row['owner'] : null);
            $address        = (!empty($row['address']) ? $row['address'] : null);
            $description    = (!empty($row['description']) ? $row['description'] : null);
            $phone          = (!empty($row['phone']) ? $row['phone'] : null);
            $url            = (!empty($row['url']) ? $row['url'] : null);
            $latlng         = (!empty($row['latlng']) ? $row['latlng'] : null);
            $category       = (!empty($row['category']) ? $row['category'] : 'Untitled Category');
            $country        = (!empty($row['country']) ? $row['country'] : null);
            $place_id       = (!empty($row['place_id']) ? $row['place_id'] : null);
            
            // Search if a category exists with that name
            $isCategory = Categories::where([['user_uuid', $user->uuid], ['name', $category]])->first();
            if(empty($isCategory))
            {
                $categorized = new Categories;
                $categorized->user_uuid = $user->uuid;
                $categorized->name = $category;
                $categorized->description = 'Nothing to declare.';
                $categorized->icon = 'map-marker-alt';
                $categorized->color = 'blue';
                $categorized->save();
                $isCategory = Categories::where([['user_uuid', $user->uuid], ['name', $category]])->first();
            }
            
            // Search if a country exists with that cca3, if it's in
            // the user's visited countries list.
            $isCodeCountry = Countries::where('cca3', 'LIKE', "%$country%")->first();
            $isUuidCountry = Countries::where('uuid', $country)->first();
            if(filled($isCodeCountry) || filled($isUuidCOuntry))
            {
                $isVisited = UserCountries::where([['user_uuid', $user->uuid], ['country_uuid', $isCountry->uuid]])->first();
                if(empty($isVisited))
                {
                    $visited = new UserCountries;
                    $visited->user_uuid = $user->uuid;
                    $visited->country_uuid = $isCountry->uuid;
                    $visited->country_cca3 = $isCountry->cca3;
                    $visited->save();
                }
            }
            
            Addresses::updateOrCreate(
                [
                    'user_uuid'     => $user->uuid,
                    'name'          => $name,
                    'latlng'        => $latlng,
                ],
                [
                    'owner'         => $owner,
                    'address'       => $address,
                    'description'   => $description,
                    'phone'         => $phone,
                    'url'           => $url,
                    'category_uuid' => $isCategory->uuid,
                    'country_uuid'  => $isCountry->uuid,
                    'place_id'      => $place_id
                    //'created_at'     => now(),
                    //'updated_at'     => now(),
                    //'deleted_at'     => now(),
            ]);
        }
    }
    
    public function chunkSize(): int
    {
        return 50;
    }
    
}
