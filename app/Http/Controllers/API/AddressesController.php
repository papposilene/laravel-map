<?php

namespace App\Http\Controllers\API;

use App\Addresses;
use App\Categories;
use App\Countries;
use App\UserCountries;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AddressesController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listing(Request $request)
    {
        $usrQuery = $request->query('user');
        $ctrQuery = strtoupper($request->query('cca3'));
        if(filled($usrQuery) && filled($ctrQuery))
        {
            $country = Countries::where('cca3', $ctrQuery)->first();
            $addresses = Addresses::where([['user_uuid', $usrQuery], ['country_uuid', $country->uuid]])->get();
        }
        elseif(filled($ctrQuery))
        {
            $country = Countries::where('cca3', $ctrQuery)->first();
            $addresses = Addresses::where('country_uuid', $country->uuid)->get();
        }
        elseif(filled($usrQuery))
        {
            $addresses = Addresses::where('user_uuid', $usrQuery)->get();
        }
        else
        {
            $addresses = Addresses::all();
        }
        return response()->json($addresses);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function point(Request $request)
    {
        $usrQuery = $request->query('user');
        $catQuery = $request->query('category');
        $ctrQuery = strtoupper($request->query('country'));
        $countries = collect();
        $features = array();
        
        if(filled($usrQuery) && filled($catQuery) && filled($ctrQuery))
        {
            $country = Countries::where('cca3', $ctrQuery)->first();
            $category = Categories::where('uuid', $catQuery)->first();
            $addresses = Addresses::where([['user_uuid', $usrQuery], ['category_uuid', $category->uuid]])->get();
        }
        elseif(filled($usrQuery) && filled($catQuery))
        {
            $category = Categories::where('uuid', $catQuery)->first();
            $addresses = Addresses::where([['user_uuid', $usrQuery], ['category_uuid', $category->uuid]])->get();
        }
        elseif(filled($usrQuery) && filled($ctrQuery))
        {
            $country = Countries::where('cca3', $ctrQuery)->first();
            $addresses = Addresses::where([['user_uuid', $usrQuery], ['country_uuid', $country->uuid]])->get();
        }
        elseif(blank($usrQuery) && filled($catQuery) && filled($ctrQuery))
        {
            $country = Countries::where('cca3', $ctrQuery)->first();
            $category = Categories::where('uuid', $catQuery)->first();
            $addresses = Addresses::where([['country_uuid', $country->uuid], ['category_uuid', $category->uuid]])->get();
        }
        elseif(blank($usrQuery) && filled($catQuery))
        {
            $category = Categories::where('uuid', $catQuery)->first();
            $addresses = Addresses::where('category_uuid', $category->uuid)->get();
        }
        elseif(blank($usrQuery) && filled($ctrQuery))
        {
            $country = Countries::where('cca3', $ctrQuery)->first();
            $addresses = Addresses::where('country_uuid', $country->uuid)->get();
        }
        elseif(filled($usrQuery) && blank($ctrQuery))
        {
            $addresses = Addresses::where('user_uuid', $usrQuery)->get();
        }
        else
        {
            $addresses = Addresses::all();
        }
        
        foreach($addresses as $address)
        {
            $category   = Categories::where('uuid', $address->category_uuid)->first();
            $country    = Countries::where('uuid', $address->country_uuid)->first();
            $phone      = (filled($address->phone) ? $address->phone : '#');
            $url        = (filled($address->url) ? $address->url : '#');
            $geoloc     = explode(', ', $address->latlng);
            $features[] = array(
                                'type' => 'Feature',
                                'geometry' => array(
                                                    'type' => 'Point',
                                                    //'coordinates' => $address->latlng,
                                                    'coordinates' => array((float)$geoloc[1],(float)$geoloc[0])
                                                    ),
                                'properties' => array(
                                                      'uuid'            => $address->uuid,
                                                      'name'            => $address->name,
                                                      'owner'           => $address->owner,
                                                      'address'         => $address->address,
                                                      'latlng'          => $address->latlng,
                                                      'phone'           => $phone,
                                                      'url'             => $url,
                                                      'description'     => $address->description,
                                                      'category_name'   => $category->name,
                                                      'category_slug'   => Str::slug($category->name),
                                                      'category_icon'   => $category->icon,
                                                      'color'           => $category->color,
                                                      'country_cca3'    => $country->cca3,
                                                      'country_common'  => $country->name_eng_common,
                                                      'country_flag'    => $country->flag,
                                                      'place_id'        => $address->place_id,
                                                    )
                                );
        }
        //dd($features);
        $allfeatures = array('user' => $usrQuery, 'type' => 'FeatureCollection', 'features' => $features);
        return json_encode($allfeatures, JSON_PRETTY_PRINT);
    }

}