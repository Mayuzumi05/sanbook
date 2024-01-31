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
            'remember_token' => Str::random(60),
        ]);

        //return response
        return new PostResource(true, 'Data User Berhasil Ditambahkan!', $user);
    }
}
