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
     * Show the index map.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userAuth = Auth::user();
        $usrQuery = $request->query('user');
        $ctrQuery = strtoupper($request->query('cca3'));
        $afCountries = collect();
        $amCountries = collect();
        $asCountries = collect();
        $euCountries = collect();
        $ocCountries = collect();
        // If an uuid's user is given
        if(filled($usrQuery))
        {
            $usrInfo = (object) ['uuid' => $usrQuery];
            if(filled($ctrQuery))
            {
                $ctrInfo = Countries::where('cca3', $ctrQuery)->first();
                $usrCountries = UserCountries::where('user_uuid', $usrQuery)->get();
            }
            else
            {
                $ctrInfo = (object) ['cca3' => null, 'latlng' => '{"lat":20, "lng":0}'];
                $usrCountries = UserCountries::where('user_uuid', $usrQuery)->get();
            }
            foreach($usrCountries as $usrCountry)
            {
                $afCountries->push(Countries::where([['region', 'Africa'], ['uuid', $usrCountry->country_uuid]])->get());
                $amCountries->push(Countries::where([['region', 'Americas'], ['uuid', $usrCountry->country_uuid]])->get());
                $asCountries->push(Countries::where([['region', 'Asia'], ['uuid', $usrCountry->country_uuid]])->get());
                $euCountries->push(Countries::where([['region', 'Europe'], ['uuid', $usrCountry->country_uuid]])->get());
                $ocCountries->push(Countries::where([['region', 'Oceania'], ['uuid', $usrCountry->country_uuid]])->get());
            }
            $catDefault = Categories::whereNull('user_uuid')->get();
            $catUser = Categories::where('user_uuid', $usrQuery)->get();
            $categories = collect([$catDefault, $catUser]);
        }
        // If there is no uuid's user but user is auth
        elseif(Auth::check())
        {
            //$usrInfo = (object) ['uuid' => $userAuth->uuid];
            $usrInfo = (object) ['uuid' => null];
            if(filled($ctrQuery))
            {
                $ctrInfo = Countries::where('cca3', $ctrQuery)->first();
                $usrCountries = UserCountries::where('user_uuid', $userAuth->uuid)->orderBy('country_cca3', 'asc')->get();
            }
            else
            {
                $ctrInfo = (object) ['cca3' => null, 'latlng' => '{"lat":20, "lng":0}'];
                $usrCountries = UserCountries::where('user_uuid', $userAuth->uuid)->orderBy('country_cca3', 'asc')->get();
            }
            foreach($usrCountries as $usrCountry)
            {
                $afCountries->push(Countries::where([['region', 'Africa'], ['uuid', $usrCountry->country_uuid]])->orderBy('created_at', 'asc')->get());
                $amCountries->push(Countries::where([['region', 'Americas'], ['uuid', $usrCountry->country_uuid]])->orderBy('created_at', 'asc')->get());
                $asCountries->push(Countries::where([['region', 'Asia'], ['uuid', $usrCountry->country_uuid]])->orderBy('created_at', 'asc')->get());
                $euCountries->push(Countries::where([['region', 'Europe'], ['uuid', $usrCountry->country_uuid]])->orderBy('created_at', 'asc')->get());
                $ocCountries->push(Countries::where([['region', 'Oceania'], ['uuid', $usrCountry->country_uuid]])->orderBy('created_at', 'asc')->get());
            }
            $catDefault = Categories::whereNull('user_uuid')->get();
            $catUser = Categories::where('user_uuid', $userAuth->uuid)->get();
            $categories = collect([$catDefault, $catUser]);
        }
        else
        {
            $usrInfo = (object) ['uuid' => null];
            if(filled($ctrQuery))
            {
                $ctrInfo = Countries::where('cca3', $ctrQuery)->first();
                $usrCountries = UserCountries::all();
            }
            else
            {
                $ctrInfo = (object) ['cca3' => null, 'latlng' => '{"lat":20, "lng":0}'];
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
            $categories = Categories::all();
        }
        return view('home', [
                                'usrInfo' => $usrInfo,
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
