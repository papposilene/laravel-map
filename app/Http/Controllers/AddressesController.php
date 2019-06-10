<?php

namespace App\Http\Controllers;

use App\Addresses;
use App\Categories;
use App\Countries;
use App\UserCountries;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressesController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function admin(Request $request)
    {
        $user = Auth::user();
        $addresses = app(Addresses::class)->newQuery();
        if ($request->has('deleted')) {
            $addresses->withTrashed();
        }
        if ($request->has('search')) {
            $addresses->where('name', 'like', '%' . $request->input('search') . '%')->orWhere('description', 'like', '%' . $request->input('search') . '%');
        }
        if ($request->has('category')) {
            $addresses->where('category_uuid', $request->query('category'));
        }
        if ($request->has('country')) {
            $addresses->where('country_uuid', $request->query('country'));
        }
        $addresses = $addresses->where('user_uuid', $user->uuid)->orderBy('updated_at', 'desc')->paginate(21);
        $catDefault = Categories::whereNull('user_uuid')->get();
        $catUser = Categories::where('user_uuid', $user->uuid)->get();
        $categories = collect([$catDefault, $catUser]);
        $countries = Countries::all();
        $visited = UserCountries::where('user_uuid', $user->uuid)->orderBy('country_cca3', 'asc')->get();
        return view('admin.addresses.index',
                        [
                            'query' => $request->query(),
                            'addresses' => $addresses,
                            'categories' => $categories->flatten(1),
                            'countries' => $countries,
                            'visited' => $visited
                        ]);
    }
	
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        if($request->country)
        {
            $request->validate([
                'country' => 'required|uuid'
            ]);
            $setCountry = Countries::find($request->country);
        }
        else
        {
            $setCountry = null;
        }
        $addresses = Addresses::where('user_uuid', $user->uuid)->limit(10);
        $catDefault = Categories::whereNull('user_uuid')->get();
        $catUser = Categories::where('user_uuid', $user->uuid)->get();
        $categories = collect($catDefault, $catUser);
        $countries = Countries::all();
        return view('admin.addresses.create', ['addresses' => $addresses, 'categories' => $categories, 'countries' => $countries, 'country' => $setCountry]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
                    [
                        'name' => 'string|required|max:255',
                        'owner' => 'string|nullable|max:255',
                        'address' => 'string|required',
                        'latlng' => 'string|required|max:255',
                        'phone' => 'string|nullable|max:255',
                        'url' => 'url|nullable|max:255',
                        'description' => 'string|nullable',
                        'user_uuid' => 'uuid|required|unique:users',
                        'category_uuid' => 'uuid|required|unique:categories',
                        'country_uuid' => 'uuid|required|unique:countries',
                        'place_id' => 'int|nullable'
                    ]);
        $uUuid = $request->user_uuid;
        $cUuid = $request->country_uuid;
        $aName = $request->name;
        $aOwnr = $request->owner;
        $aAddr = $request->address;
        $aGeol = $request->latlng;
        $aDesc = $request->description;
        $aPhon = $request->phone;
        $aSite = $request->url;
        $aCate = $request->category_uuid;
        $aPlId = $request->place_id;
        
        $isVisited = UserCountries::where([['user_uuid', $uuuid], ['country_uuid', $cuuid]])->first();
        if(empty($isVisited))
        {
            // New visited country
            $country = Countries::where('uuid', $cuuid)->firstOrFail();
            $visited = new UserCountries;
            $visited->user_uuid = $uuuid;
            $visited->country_uuid = $cuuid;
            $visited->country_cca3 = $country->cca3;
            $visited->save();
        }
        // New address in an already visited country
        $address = new Addresses;
        $address->name          = $aName;
        $address->owner         = $aOwnr;
        $address->address       = $aAddr;
        $address->description   = $aDesc;
        $address->phone         = $aPhon;
        $address->url           = $aSite;
        $address->latlng        = $aGeol;
        $address->user_uuid     = $uUuid;
        $address->category_uuid = $aCate;
        $address->country_uuid  = $cUuid;
        $address->place_id      = $aPlId;
        $address->save();
        return redirect()->route('address.admin')->with('status', 'addOk');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Addresses  $addresses
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $address = Addresses::find($uuid);
        $categories = Categories::all();
        $countries = Countries::all();
        return view('admin.addresses.edit', ['address' => $address, 'categories' => $categories, 'countries' => $countries]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate(
                    [
                        'user_uuid' => 'required|uuid',
                        'addr_uuid' => 'required|uuid',
                        'name' => 'string|required|max:255',
                        'owner' => 'string|nullable|max:255',
                        'address' => 'string|required',
                        'latlng' => 'string|required|max:255',
                        'phone' => 'string|nullable|max:255',
                        'url' => 'url|nullable|max:255',
                        'description' => 'string|nullable',
                        'category_uuid' => 'uuid|required|unique:categories',
                        'country_uuid' => 'uuid|required|unique:countries'
                    ]);
        $uUuid = $request->user_uuid;
        $aUuid = $request->addr_uuid;
        $aName = $request->name;
        $aOwnr = $request->owner;
        $aAddr = $request->address;
        $cUuid = $request->country_uuid;
        $aGeol = $request->latlng;
        $aDesc = $request->description;
        $aPhon = $request->phone;
        $aSite = $request->url;
        $aCate = $request->category_uuid;
        
        $isVisited = UserCountries::where([['user_uuid', $uUuid], ['country_uuid', $cUuid]])->first();
        if(empty($isVisited))
        {
            // New visited country
            $country = Countries::where('uuid', $cuuid)->firstOrFail();
            $visited = new UserCountries;
            $visited->user_uuid = $uuuid;
            $visited->country_uuid = $cuuid;
            $visited->country_cca3 = $country->cca3;
            $visited->save();
        }
            
        // Update an existing address
        $address = Addresses::find($aUuid);
        $address->name          = $aName;
        $address->owner         = $aOwnr;
        $address->address       = $aAddr;
        $address->description   = $aDesc;
        $address->phone         = $aPhon;
        $address->url           = $aSite;
        $address->latlng        = $aGeol;
        $address->country_uuid  = $cUuid;
        $address->category_uuid = $aCate;
        $address->save();
        return redirect()->route('address.admin')->with('status', 'updOk');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $uuidAdd = $request->query('uuid');
        $address = Addresses::find($uuidAdd);
        $address->delete();
        return redirect()->route('address.admin')->with('status', 'delOk');
    }
	
    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request)
    {
        $uuidAdd = $request->query('uuid');
        Addresses::onlyTrashed()->where('uuid', $uuidAdd)->restore();
        return redirect()->route('address.admin')->with('status', 'resOk');
    }
}
