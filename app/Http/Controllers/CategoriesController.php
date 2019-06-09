<?php

namespace App\Http\Controllers;

use App\Addresses;
use App\Categories;
use App\Countries;
use App\UserCountries;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$categories = Categories::all();
		$addresses = Addresses::all();
        return view('categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin(Request $request)
    {
        $user = Auth::user();
        $qdel = $request->query('deleted');
        $catDefault = Categories::whereNull('user_uuid')->get();
        if(isset($qdel))
        {
			$catUser = Categories::withTrashed()->where('user_uuid', $user->uuid)->get();
        }
        else
        {
			$catUser = Categories::where('user_uuid', $user->uuid)->get();
        }
        $categories = collect([$catDefault, $catUser]);
        return view('admin.categories.index', ['query' => $qdel, 'categories' => $categories->flatten(1)]);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Countries  $countries
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
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
                'icon' => 'required|string|max:255',
                'color' => 'required|string|max:255',
                'description' => 'string|nullable',
                'user_uuid' => 'required|uuid|unique:users'
            ]);
            $uuidUsr = $request->user_uuid;
            $nameCat = $request->name;
            $iconCat = $request->icon;
            $colorCat = $request->color;
            $descCat = $request->description;

            // New categorie
            $category = new Categories;
            $category->name         = $nameCat;
            $category->icon         = $iconCat;
            $category->color        = $colorCat;
            $category->description  = $descCat;
            $category->user_uuid    = $uuidUsr;
            $category->save();
            return redirect()->route('category.admin')->with('status', 'addOk');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Countries  $countries
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $category = Categories::find($uuid);
        return view('admin.categories.edit')->with('category', $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Countries  $countries
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $uuidUsr = $request->user_uuid;
        if($user->uuid === $uuidUsr)
        {
            $request->validate([
                'cat_uuid' => 'required|uuid',
                'name' => 'required|max:255',
                'icon' => 'required|string|max:255',
                'color' => 'required|string|max:255',
                'description' => 'string|nullable',
                'user_uuid' => 'required|uuid|unique:users'
            ]);
            $uuidCat = $request->cat_uuid;
            $nameCat = $request->name;
            $iconCat = $request->icon;
            $colorCat = $request->color;
            $descCat = $request->description;

            // Updating a category
            $category = Categories::find($uuidCat);
            $category->name         = $nameCat;
            $category->icon         = $iconCat;
            $category->color        = $colorCat;
            $category->description  = $descCat;
            $category->save();
            return redirect()->route('category.admin')->with('status', 'updOk');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Countries  $countries
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $uuidCat = $request->query('uuid');
        Categories::destroy($uuidCat);
        return redirect()->route('category.admin')->with('status', 'delOk');
    }
    
    /**
     * Restore the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request)
    {
        $uuidCat = $request->query('uuid');
        Categories::withTrashed()->where('uuid', $uuidCat)->restore();
        return redirect()->route('category.admin')->with('status', 'resOk');
    }
}
