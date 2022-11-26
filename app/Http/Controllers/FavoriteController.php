<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Http\Requests\StoreFavoriteRequest;
use App\Http\Requests\UpdateFavoriteRequest;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $favorites = Favorite::where('user_id', Auth::user()->id)->get();

        if(count($favorites)){
            return response()->json([
                'status' => true,
                'data'      => $favorites,
                'message' => __('User data'),
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => __('Without results'),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFavoriteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFavoriteRequest $request)
    {
        try {
            $credentials = $request->only([
                'ref_api',
            ]);

            $credentials['user_id'] = Auth::user()->id;

            $favorite = Favorite::create($credentials);

            return response()->json([
                'status' => true,
                'data'      => $favorite,
                'message' => __('Character added to favorites!'),
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favorite $favorite)
    {
        if($favorite->user_id == Auth::user()->id){
            $favorite->delete();

            return response()->json([
                'status' => true,
                'message' => __('Character removed from favorites'),
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => __('Unauthorized'),
        ], 401);
    }
}
