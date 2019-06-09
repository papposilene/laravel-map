<?php

namespace App\Http\Controllers;

use App\Addresses;
use App\Categories;
use App\Countries;
use App\UserCountries;
use App\Exports\UserAddressesExport;
use App\Exports\UserCategoriesExport;
use App\Exports\UserCountriesExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $totalUserAddresses = Addresses::where('user_uuid', $user->uuid)->count();
        $totalUserCategories = Categories::where('user_uuid', $user->uuid)->count();
        $totalUserCountries = UserCountries::where('user_uuid', $user->uuid)->count();
        return view('admin.export',
                    [
                        'totalUserAddresses'  => $totalUserAddresses,
                        'totalUserCategories' => $totalUserCategories,
                        'totalUserCountries' => $totalUserCountries,
                    ]);
    }

    /**
     * Export the list of all addresses into a file
     *
     * @param  string $type
     * @return \Illuminate\Http\Response
     */
    public function addresses($type)
    {
        $user = Auth::user();
        if($type === 'ods')
        {
            $filename = 'addresses_' . date('Y-m-d_H-i-s') . '.ods';
            return (new UserAddressesExport)->forUser($user->uuid)->download($filename, \Maatwebsite\Excel\Excel::ODS);
        }
        elseif($type === 'csv')
        {
            $filename = 'addresses_' . date('Y-m-d_H-i-s') . '.csv';
            return (new UserAddressesExport)->forUser($user->uuid)->download($filename, \Maatwebsite\Excel\Excel::CSV);
        }
        elseif($type === 'html')
        {
            $filename = 'addresses_' . date('Y-m-d_H-i-s') . '.html';
            return (new UserAddressesExport)->forUser($user->uuid)->download($filename, \Maatwebsite\Excel\Excel::HTML);
        }
        else
        {
            $filename = 'addresses_' . date('Y-m-d_H-i-s') . '.xlsx';
            return (new UserAddressesExport)->forUser($user->uuid)->download($filename, \Maatwebsite\Excel\Excel::XLSX);
        }
    }
    
    /**
     * Export the list of all user-created categories into a file
     *
     * @param  string $type
     * @return \Illuminate\Http\Response
     */
    public function categories($type)
    {
        $user = Auth::user();
        if($type === 'ods')
        {
            $filename = 'categories_' . date('Y-m-d_H-i-s') . '.ods';
            return (new UserCategoriesExport)->forUser($user->uuid)->download($filename, \Maatwebsite\Excel\Excel::ODS);
        }
        elseif($type === 'csv')
        {
            $filename = 'categories_' . date('Y-m-d_H-i-s') . '.csv';
            return (new UserCategoriesExport)->forUser($user->uuid)->download($filename, \Maatwebsite\Excel\Excel::CSV);
        }
        elseif($type === 'html')
        {
            $filename = 'categories_' . date('Y-m-d_H-i-s') . '.html';
            return (new UserCategoriesExport)->forUser($user->uuid)->download($filename, \Maatwebsite\Excel\Excel::HTML);
        }
        else
        {
            $filename = 'categories_' . date('Y-m-d_H-i-s') . '.xlsx';
            return (new UserCategoriesExport)->forUser($user->uuid)->download($filename, \Maatwebsite\Excel\Excel::XLSX);
        }
    }

    /**
     * Export the list of all visited countries into a file
     *
     * @param  string $type
     * @return \Illuminate\Http\Response
     */
    public function countries($type)
    {
        $user = Auth::user();
        if($type === 'ods')
        {
            $filename = 'countries_' . date('Y-m-d_H-i-s') . '.ods';
            return (new UserCountriesExport)->forUser($user->uuid)->download($filename, \Maatwebsite\Excel\Excel::ODS);
        }
        elseif($type === 'csv')
        {
            $filename = 'countries_' . date('Y-m-d_H-i-s') . '.csv';
            return (new UserCountriesExport)->forUser($user->uuid)->forUser($user->uuid)->download($filename, \Maatwebsite\Excel\Excel::CSV);
        }
        elseif($type === 'html')
        {
            $filename = 'countries_' . date('Y-m-d_H-i-s') . '.html';
            return (new UserCountriesExport)->forUser($user->uuid)->download($filename, \Maatwebsite\Excel\Excel::HTML);
        }
        else
        {
            $filename = 'countries_' . date('Y-m-d_H-i-s') . '.xlsx';
            return (new UserCountriesExport)->forUser($user->uuid)->download($filename, \Maatwebsite\Excel\Excel::XLSX);
        }
    }
}
