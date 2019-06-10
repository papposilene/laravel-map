<?php

namespace App\Http\Controllers;

use App\Addresses;
use App\Categories;
use App\Countries;
use App\User;
use App\UserCountries;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    
    /**
     * Show the index map.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function home(Request $request)
    {        
        $usrQuery = $request->query('user');
        $addresses = Addresses::all();
        $countries = Countries::all();
        // If an uuid's user is given
        if(filled($usrQuery))
        {
            $usrInfo = (object) ['uuid' => $usrQuery];
            $catDefault = Categories::whereNull('user_uuid')->get();
            $catUser = Categories::where('user_uuid', $usrQuery)->get();
            $categories = collect([$catDefault, $catUser]);
            $visited = UserCountries::where('user_uuid', $usrQuery)->get();
        }
        // If there is no uuid's user but user is auth
        elseif(Auth::check())
        {
            $userAuth = Auth::user();
            $usrInfo = (object) ['uuid' => null];
            $catDefault = Categories::whereNull('user_uuid')->get();
            $catUser = Categories::where('user_uuid', $userAuth->uuid)->get();
            $categories = collect([$catDefault, $catUser]);
            $visited = UserCountries::where('user_uuid', $userAuth->uuid)->orderBy('country_cca3', 'asc')->get();
        }
        else
        {
            $usrInfo = (object) ['uuid' => null];
            $categories = Categories::all();
            $visited = UserCountries::all();
        }
        return view('list',
                        [
                            'usrInfo' => $usrInfo,
                            'addresses' => $addresses,
                            'categories' => $categories->flatten(),
                            'countries' => $countries,
                            'visited' => $visited
                        ]);
    }
    
    /**
     * Show the index map.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function map(Request $request)
    {
        $afCountries = collect();
        $amCountries = collect();
        $asCountries = collect();
        $euCountries = collect();
        $ocCountries = collect();
        $catInfo = (object) ['uuid' => $request->query('category')];
        // If an uuid's user is given
        if ($request->has('user')) {
            $usrInfo = User::find($request->query('user'));
            $catDefault = Categories::whereNull('user_uuid')->get();
            $catUser = Categories::where('user_uuid', $usrInfo->uuid)->get();
            $categories = collect([$catDefault, $catUser]);
            // If country
            if ($request->has('country')) {
                $ctrInfo = Countries::where('cca3', strtoupper($request->query('country')))->first();
                $usrCountries = UserCountries::where('user_uuid', $usrInfo->uuid)->get();
            }
            else
            {
                $ctrInfo = (object) ['cca3' => null, 'latlng' => '{"lat":20, "lng":0}'];
                $usrCountries = UserCountries::where('user_uuid', $usrInfo->uuid)->get();
            }
        }
        // If there is no uuid's user but user is auth
        elseif(Auth::check()) {
            $userAuth = Auth::user();
            $usrInfo = (object) ['uuid' => null];
            $catDefault = Categories::whereNull('user_uuid')->get();
            $catUser = Categories::where('user_uuid', $userAuth->uuid)->get();
            $categories = collect([$catDefault, $catUser]);
            // If country
            if ($request->has('country')) {
                $ctrInfo = Countries::where('cca3', strtoupper($request->query('country')))->first();
                $usrCountries = UserCountries::where('user_uuid', $userAuth->uuid)->get();
            }
            else
            {
                $ctrInfo = (object) ['cca3' => null, 'latlng' => '{"lat":20, "lng":0}'];
                $usrCountries = UserCountries::where('user_uuid', $userAuth->uuid)->get();
            }
        }
        else {
            $usrInfo = (object) ['uuid' => null];
            $categories = Categories::all();
            // If country
            if ($request->has('country')) {
                $ctrInfo = Countries::where('cca3', strtoupper($request->query('country')))->first();
            }
            else
            {
                $ctrInfo = (object) ['cca3' => null, 'latlng' => '{"lat":20, "lng":0}'];
            }
            $usrCountries = UserCountries::all();
        }
        
        foreach($usrCountries as $usrCountry)
        {
            $afCountries->push(Countries::where([['region', 'Africa'], ['uuid', $usrCountry->country_uuid]])->get());
            $amCountries->push(Countries::where([['region', 'Americas'], ['uuid', $usrCountry->country_uuid]])->get());
            $asCountries->push(Countries::where([['region', 'Asia'], ['uuid', $usrCountry->country_uuid]])->get());
            $euCountries->push(Countries::where([['region', 'Europe'], ['uuid', $usrCountry->country_uuid]])->get());
            $ocCountries->push(Countries::where([['region', 'Oceania'], ['uuid', $usrCountry->country_uuid]])->get());
        }
        
        return view('map', [
                                'usrInfo' => $usrInfo,
                                'catInfo' => $catInfo,
                                'ctrInfo' => $ctrInfo,
                                'categories' => $categories->flatten(),
                                'afCountries' => $afCountries->flatten(),
                                'amCountries' => $amCountries->flatten(),
                                'asCountries' => $asCountries->flatten(),
                                'euCountries' => $euCountries->flatten(),
                                'ocCountries' => $ocCountries->flatten()
                            ]);
    }
	
}
