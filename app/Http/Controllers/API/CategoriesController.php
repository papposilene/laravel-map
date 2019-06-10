<?php

namespace App\Http\Controllers\API;

use App\Categories;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function json(Request $request)
    {
        $user = $request->query('user');
        $query = $request->query('query');
        $catDefault = Categories::where([['user_uuid', null], ['name', 'like', "%$query%"]])->orWhere([['user_uuid', null], ['description', 'like', "%$query%"]])->get();
        $catUser = Categories::where([['user_uuid', $user], ['name', 'like', "%$query%"]])->orWhere([['user_uuid', $user], ['description', 'like', "%$query%"]])->get();
        $categories = collect([$catDefault, $catUser]);
        $rawdata = json_decode($categories->flatten(1), true);
        $allfeatures = array('categories' => $rawdata);
        return json_encode($allfeatures, JSON_PRETTY_PRINT);
    }

}