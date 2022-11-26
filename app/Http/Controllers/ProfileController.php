<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function get(){

        return response()->json([
            'status' => true,
            'data'      => Auth::user(),
            'message' => __('User data'),
        ], 200);
    }


    public function update(UpdateProfileRequest $request, User $user){
        try{
            $credentials = $request->only([
                'name',
                'email',
                'password',
                'address',
                'city',
                'birthdate'
            ]);

            $okUpdate = $user->fill($credentials)->save();

            if ($okUpdate) {
                return response()->json([
                    'status' => true,
                    'data'      => $user,
                    'message' => __('The :resource was updated!', ['resource' => 'user']),
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'oops try again',
            ], 500);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }


    }
}
