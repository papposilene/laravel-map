<?php

namespace App\Http\Controllers;

use App\Addresses;
use App\Categories;
use App\Countries;
use App\UserCountries;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $userData = User::find($user->uuid);
        // Categories
        $allCategories = Categories::all();
        $userCat = Categories::where('user_uuid', $user->uuid)->get();
        $totalCategories = Categories::count();
        $totalUserCategories = Categories::where('user_uuid', $user->uuid)->count();
        $lastCategory = Categories::orderBy('updated_at', 'asc')->first();
        // Countries
        $allCountries = Countries::all();
        $userCountries = UserCountries::where('user_uuid', $user->uuid)->get();
        $totalCountries = Countries::count();
        $totalUserCountries = UserCountries::where('user_uuid', $user->uuid)->count();
        $lastCountry = UserCountries::where('user_uuid', $user->uuid)->orderBy('updated_at', 'asc')->first();
        // Addresses
        $allAddresses = Addresses::all();
        $userAddresses = Addresses::where('user_uuid', $user->uuid)->get();
        $totalAddresses = Addresses::count();
        $totalUserAddresses = Addresses::where('user_uuid', $user->uuid)->count();
        $lastAddress = Addresses::where('user_uuid', $user->uuid)->orderBy('updated_at', 'asc')->first();
        if($totalUserAddresses < 1)
        {
            return redirect()->route('address.create');
        }
        else
        {
            return view('admin.index',
                [
                    'userData' => $userData,
                    'allCategories' => $allCategories,
                    'userCat' => $userCat,
                    'totalCategories' => $totalCategories,
                    'totalUserCategories' => $totalUserCategories,
                    'lastCategory' => $lastCategory,
                    'allCountries' => $allCountries,
                    'userCountries' => $userCountries,
                    'totalCountries' => $totalCountries,
                    'totalUserCountries' => $totalUserCountries,
                    'lastCountry' => $lastCountry,
                    'allAddresses' => $allAddresses,
                    'userAddresses' => $userAddresses,
                    'totalAddresses' => $totalAddresses,
                    'totalUserAddresses' => $totalUserAddresses,
                    'lastAddress' => $lastAddress
                ]);
        }
    }

}
