<?php

use App\Countries;
use App\CountriesGeometry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CountriesGeometrySeeder extends Seeder
{    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries_geometry')->delete();
        // Borders   https://github.com/georgique/world-geojson
        $countries = Countries::all();
        foreach ($countries as $dtb)
        {
            $borderFile = database_path('data/countries/' . strtolower($dtb->cca3) . '.json');
            if(file_exists($borderFile))
            {
                $bordersFile = File::get($borderFile);
                $bordersData = json_decode($bordersFile, true);
                //$borders_poly = json_encode($bordersData['features'][0]['geometry']['coordinates'], JSON_FORCE_OBJECT);
                $geoCollection = GeometryCollection::fromJson($bordersData);
            }
            Countries::create([
                'country_uuid'  => $dtb->uuid,
                'country_cca3'  => $dtb->cca3,
                'geometry'      => $geoCollection
			]);
        }
    }
}
