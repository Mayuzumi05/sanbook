<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    //
    public function store(Request $request) {

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required',
            ]);
    
            //check if validation fails
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
    
            //create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                // 'remember_token' => Str::random(60),
            ]);
    
            return response()->json([
                'status' => true,
                'message' => 'Data User Berhasil Ditambahkan!',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

            //return response
            // return new PostResource(true, 'Data User Berhasil Ditambahkan!', $user);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
