<?php

use App\Countries;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->delete();
        // Countries https://github.com/mledoze/countries/blob/master/countries.json
        $countriesFile = File::get('database/data/countries.json');
        $countriesData = json_decode($countriesFile);
        foreach ($countriesData as $dtb)
        {
            $landlocked     = ($dtb->landlocked === true ? 'true' : 'false');
            $independent    = ($dtb->independent === true ? 'true' : 'false');
            $status         = ($dtb->status === true ? 'true' : 'false');
            $latlng         = json_encode(array('lat' => $dtb->latlng[1], 'lng' => $dtb->latlng[0]));
            $neighbourhood  = (empty($dtb->borders) ? 'null' : json_encode($dtb->borders, JSON_FORCE_OBJECT));
            Countries::create([
                'name_eng_common'   => addslashes($dtb->name->common),
                'name_eng_official' => addslashes($dtb->name->official),
                'cca2'              => $dtb->cca2,
                'cca3'              => $dtb->cca3,
                'cioc'              => $dtb->cioc,
                'tlds'              => json_encode($dtb->tld, JSON_FORCE_OBJECT),
                'ccn3'              => $dtb->ccn3,
                'area'              => $dtb->area,
                'region'            => $dtb->region,
                'subregion'         => $dtb->subregion,
                'latlng'            => $latlng,
                'landlocked'        => $landlocked,
                'neighbourhood'     => $neighbourhood,
                'status'            => $status,
                'independent'       => $independent,
                'flag'              => $dtb->flag,
                'currency'          => json_encode($dtb->currency, JSON_FORCE_OBJECT),
                'capital'           => json_encode($dtb->capital, JSON_FORCE_OBJECT),
                'demonym'           => addslashes($dtb->demonym),
                'languages'         => json_encode($dtb->languages, JSON_FORCE_OBJECT),
                'name_native'       => json_encode($dtb->name->native, JSON_FORCE_OBJECT),
                'name_translations' => json_encode($dtb->translations, JSON_FORCE_OBJECT)
			]);
        }
    }
}
