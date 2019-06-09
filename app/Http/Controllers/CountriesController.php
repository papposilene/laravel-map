<?php

namespace App\Http\Controllers;

use App\Addresses;
use App\Categories;
use App\Countries;
use App\UserCountries;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CountriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = Countries::all();
        $addresses = Addresses::all();
        return view('countries.index', ['addresses' => $addresses, 'countries' => $countries]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        $user = Auth::user();
        $visited = UserCountries::where('user_uuid', $user->uuid)->get();
        $countries = collect();
        foreach($visited as $visit)
        {
            $countries->push(Countries::where('uuid', $visit->country_uuid)->get());
        }
        $countries = $countries->flatten(1);
        $countries = $countries->sortBy('cca3');
        $addresses = Addresses::where('user_uuid', $user->uuid)->get();
        return view('admin.countries.index', ['countries' => $countries, 'visited' => $visited, 'addresses' => $addresses]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Countries  $countries
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $countries = Countries::all();
        $visited = UserCountries::where('user_uuid', $user->uuid)->get();
        return view('admin.countries.create', ['countries' => $countries, 'visited' => $visited]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserCountries  $userCountries
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
                'user_uuid' => 'required|uuid',
                'country_uuid' => 'required|uuid',
                'country_cca3' => 'required|alpha|size:3',
            ]);
        $user = Auth::user();
        $uuidUsr = $request->user_uuid;
        $uuidCtr = $request->country_uuid;
        $cca3Ctr = $request->country_cca3;
        $isTrashed = UserCountries::withTrashed()->where([['user_uuid', $uuidUsr], ['country_uuid', $uuidCtr], ['country_cca3', $cca3Ctr]])->first();
        if(isset($isTrashed->deleted_at))
        {
            // Restore an already visited country
            UserCountries::withTrashed()->where([['user_uuid', $uuidUsr], ['country_uuid', $uuidCtr], ['country_cca3', $cca3Ctr]])->restore();
            return redirect()->route('country.admin')->with('status', 'resOk');
        }
        else
        {
            // Add a new visited country
            UserCountries::updateOrCreate([
                'user_uuid' => $uuidUsr,
                'country_uuid' => $uuidCtr,
                'country_cca3' => $cca3Ctr
            ]);
            return redirect()->route('country.admin')->with('status', 'addOk');
        }
        
    }
    
    /**
     * Delete the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
                'country_uuid' => 'required|uuid',
                'user_uuid' => 'required|uuid'
            ]);
        $user = Auth::user();
        $uuidUsr = $request->user_uuid;
        $uuidVisited = $request->uuid;
        if($user->uuid === $uuidUsr)
        {
            UserCountries::destroy($uuidVisited);
            return redirect()->route('country.admin')->with('status', 'delOk');
        }
    }
    
    /**
     * Restore the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request)
    {
        $request->validate([
                'uuid' => 'required|uuid',
                'user_uuid' => 'required|uuid'
            ]);
        $user = Auth::user();
        $uuuid = $request->user_uuid;
        $uuidVisited = $request->uuid;
        if($user->uuid === $uuuid)
        {
            UserCountries::withTrashed()->where('uuid', $uuidVisited)->restore();
            return redirect()->route('country.admin')->with('status', 'resOk');
        }
    }

}
