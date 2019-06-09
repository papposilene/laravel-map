<?php

namespace App\Http\Controllers\API;

use App\Countries;
use App\UserCountries;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CountriesController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listing(Request $request)
    {
        $query = $request->query('query');
        if(isset($query))
        {
            $countries = Countries::where('name_translations', 'like', "%$query%")->get();
        }
        else
        {
            $countries = Countries::all();
        }
        return response()->json($countries);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function point(Request $request)
    {
        $user = $request->query('user');
        $query = $request->query('cca3');
        $countries = collect();
        $features = array();
        
        if(isset($user))
        {
            $visited = UserCountries::where('user_uuid', $user)->get();
            foreach($visited as $visit)
            {
                $countries->push(Countries::where('uuid', $visit->country_uuid)->get());
            }
            $countries = $countries->flatten(1);
        }
        elseif(isset($query))
        {
            $cca3s = explode(',', $query);
            foreach($cca3s as $cca3)
            {
                $countries->push(Countries::where('cca3', $cca3)->get());
            }
            //dd($countries->flatten(2));
            $countries = $countries->flatten(1);
        }
        else
        {
            $countries = Countries::all();
        }
        
        foreach($countries as $country)
        {
            $geoloc = json_decode($country->latlng, true);
            $features[] = array(
                                'type' => 'Feature',
                                'geometry' => array(
                                                    'type' => 'Point',
                                                    'coordinates' => array(
                                                                           (float) $geoloc['lat'],
                                                                           (float) $geoloc['lng']
                                                                           )
                                                    ),
                                'properties' => array(
                                                      'uuid' => $country->uuid,
                                                      'cca2' => $country->cca2,
                                                      'cca3' => $country->cca3,
                                                      'name_common' => $country->name_eng_common,
                                                      'name_official' => $country->name_eng_official,
                                                      'name_translations' => json_decode($country->name_translations)
                                                      )
                                );
        }
        //dd($features);
        $allfeatures = array('type' => 'FeatureCollection', 'features' => $features);
        return json_encode($allfeatures, JSON_PRETTY_PRINT);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function polygon($user, Request $request)
    {
        $query = $request->query('term');
        $featColl = collect();
        $featJson = array();
        $visited = UserCountries::where('user_uuid', $user)->get();
        foreach($visited as $visit)
        {
            $featColl->push(Countries::where([['uuid', $visit->country_uuid], ['name_translations', 'like', "%$query%"]])->select('uuid', 'cca3', 'name_eng_common', 'name_translations', 'borders_poly')->get());
        }
        $rawData = json_decode($featColl, true);
        //dd($rawData);
        foreach($rawData as $key => $value) {
            $i = 0;
            $featPoly = array();
            foreach($value[$i]['borders_poly'] as $polyData)
            {
                $featPoly[] = json_decode($polyData, true);
            }
            
            $features[] = array(
                            'type' => 'Feature',
                            'geometry' => array(
                                                'type' => 'Polygon',
                                                'coordinates' => $featPoly
                                            ),
                            'properties' => array(
                                                'uuid' => $value[$i]['uuid'],
                                                'cca3' => $value[$i]['cca3'],
                                                'name_common' => $value[$i]['name_eng_common'],
                                                'name_translations' => $value[$i]['name_translations']
                                            ),
                        );
        }
        
        $allfeatures = array('type' => 'FeatureCollection', 'features' => $features);
        return json_encode($allfeatures, JSON_PRETTY_PRINT);
    }

}