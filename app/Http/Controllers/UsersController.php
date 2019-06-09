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

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Categories::where('user_uuid', $user->uuid)->get();
		$countries = UserCountries::where('user_uuid', $user->uuid)->get();
        $addresses = Addresses::where('user_uuid', $user->uuid)->get();
        return view('admin.users.index', ['addresses' => $addresses, 'categories' => $categories, 'countries' => $countries]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        $user = Auth::user();
        $countries = Countries::all();
        $visited = UserCountries::where('user_uuid', $user->uuid)->get();
        $addresses = Addresses::where('user_uuid', $user->uuid)->get();
        return view('admin.users.index', ['countries' => $countries, 'visited' => $visited, 'addresses' => $addresses]);
    }

    /**
     * Display the specified resource.
     *
     * @param  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $uuid
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Users $users
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $uuid = $request->user_uuid;
        if($user->uuid === $request->user_uuid)
        {
            $request->validate([
				'username' => 'required|string|max:255',
				'title' => 'required|string|max:255',
				'fname' => 'required|string|max:255',
				'lname' => 'required|string|max:255',
				'email' => 'required|email|unique:users|max:255',
				'password' => 'required|string|min:8|confirmed',
			]);
			
			$updUser = User::find($user->uuid);
			$updUser->username = $request->username;
			$updUser->title = $request->title;
			$updUser->fname = $request->fname;
			$updUser->lname = $request->lname;
			$updUser->email = $request->email;
			$updUser->password = Hash::make($request->password);
			$updUser->save();
            return redirect()->route('user.index')->with('notification', 'updOk');
        }
    }

}
