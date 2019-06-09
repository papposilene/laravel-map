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
        $user = Auth::user();
        $uuid = $request->user_uuid;
        if($user->uuid === $request->user_uuid)
        {

            $request->validate([
                'name' => 'required|max:255',
                'address' => 'required|string',
                'latlng' => 'required|string|max:255',
                'phone' => 'string|nullable|max:255',
                'url' => 'url|nullable|max:255',
                'description' => 'string|nullable',
                'user_uuid' => 'required|uuid|unique:users',
                'category_uuid' => 'required|uuid|unique:categories',
                'country_uuid' => 'required|uuid|unique:countries',
                'place_id' => 'int|nullable',
            ]);
            $uuuid = $request->user_uuid;
            $cuuid = $request->country_uuid;
            $aname = $request->name;
            $aaddr = $request->address;
            $ageol = $request->latlng;
            $adesc = $request->description;
            $aphon = $request->phone;
            $aurl = $request->url;
            $acate = $request->category_uuid;
            $aplid = $request->place_id;
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
            $address->name          = $aname;
            $address->address       = $aaddr;
            $address->description   = $adesc;
            $address->phone         = $aphon;
            $address->url           = $aurl;
            $address->latlng        = $ageol;
            $address->user_uuid     = $uuuid;
            $address->category_uuid = $acate;
            $address->country_uuid  = $cuuid;
            $address->place_id      = $aplid;
            $address->save();
            return redirect()->route('address.admin')->with('status', 'addOk');
        }
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
        $uuidUsr = $request->user_uuid;
        if($user->uuid === $uuidUsr)
        {
            $request->validate([
                    'addr_uuid' => 'required|uuid',
                    'name' => 'required|max:255',
                    'address' => 'required|string',
                    'latlng' => 'required|string|max:255',
                    'phone' => 'string|nullable|max:255',
                    'url' => 'url|nullable|max:255',
                    'description' => 'string|nullable',
                    'category_uuid' => 'required|uuid|unique:categories'
            ]);
            $uuidAdd = $request->addr_uuid;
            $nameAdd = $request->name;
            $addrAdd = $request->address;
            $geolAdd = $request->latlng;
            $descAdd = $request->description;
            $phonAdd = $request->phone;
            $urlAdd = $request->url;
            $cateAdd = $request->category_uuid;
            
            // Update an existing address
            $address = Addresses::find($uuidAdd);
            $address->name          = $nameAdd;
            $address->address       = $addrAdd;
            $address->description   = $descAdd;
            $address->phone         = $phonAdd;
            $address->url           = $urlAdd;
            $address->latlng        = $geolAdd;
            $address->category_uuid = $cateAdd;
            $address->save();
            return redirect()->route('address.admin')->with('status', 'updOk');
        }
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
