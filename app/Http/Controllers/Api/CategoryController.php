<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //
    public function index() {
        $category = Category::latest()->get();

        return new PostResource(true, 'List Data Book', $category);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $category = Category::create([
            'name' => $request->name
        ]);

        //return response
        return new PostResource(true, 'Data Category Berhasil Ditambahkan!', $category);
    }

    public function show(Category $category)
    {
        //return single post as a resource
        return new PostResource(true, 'Data Category Ditemukan!', $category);
    }

    public function update(Request $request, Category $category)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //update post without image
        $category->update([
            'name' => $request->name,
        ]);

        //return response
        return new PostResource(true, 'Data Book Berhasil Diubah!', $category);
    }

    public function destroy(Category $category)
    {
        //delete image
        Storage::delete('public/posts/'.$category->image);

        //delete post
        $category->delete();

        //return response
        return new PostResource(true, 'Data Category Berhasil Dihapus!', null);
    }
}
