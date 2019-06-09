<?php

namespace App\Http\Controllers;

use App\Addresses;
use App\Categories;
use App\Countries;
use App\UserCountries;
use App\Imports\UserAddressesImport;
use App\Imports\UserCategoriesImport;
use App\Imports\UserCountriesImport;
use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    /**
     * Show the index map.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.import');
    }
	
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
		$request->validate([
            'importedfile' => 'mimes:xls,xlsx,csv,ods,xml'
        ]);
		$user = Auth::user();
		$type = $request->type;
		$file = $request->file('importedfile');
		if($type === 'user_categories')
		{
			Excel::import(new UserCategoriesImport, $file);
		}
		elseif($type === 'user_countries')
		{
			Excel::import(new UserCountriesImport, $file);
		}
		elseif($type === 'user_addresses')
		{
			Excel::import(new UserAddressesImport, $file);
		}
		else
		{
			return redirect()->route('import.index')->with('status', 'impFail');
		}
		return redirect()->route('import.index')->with('status', 'impOk');
    }
	
}