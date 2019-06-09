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
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
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
     * Show the form for editing the specified resource.
     *
     * @param  $uuid
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $user = User::find($uuid);
        return view('admin.users.edit', ['user' => $user]);
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
        //dd($request->all());
        $request->validate([
            'uuid' => 'required|uuid',
            'username' => 'required|string|max:255',
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);
        if($user->uuid === $request->uuid)
        {
            $updUser = User::find($user->uuid);
            $updUser->username = $request->username;
            $updUser->title = $request->title;
            $updUser->fname = $request->fname;
            $updUser->lname = $request->lname;
            $updUser->email = $request->email;
            $updUser->password = Hash::make($request->password);
            $updUser->save();
            return redirect()->route('admin.index')->with('status', 'updOk');
        }
    }

}
