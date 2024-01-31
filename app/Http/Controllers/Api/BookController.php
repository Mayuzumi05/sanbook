<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    //
    public function index() {
        $books = Book::latest()->get();

        return new PostResource(true, 'List Data Book', $books);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'image_url'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'release_year'     => 'required',
            'title'     => 'required',
            'price'   => 'required',
            'total_page'   => 'required',
            'category_id'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('image_url');
        $image->storeAs('public/books', $image->hashName());

        //create post
        $book = Book::create([
            'image_url'     => $image->hashName(),
            'title'     => $request->title,
            'description'   => $request->description,
            'release_year'   => $request->release_year,
            'price'   => $request->price,
            'total_page'   => $request->total_page,
            'thickness'   => $request->thickness,
            'category_id'   => $request->category_id,
        ]);

        //return response
        return new PostResource(true, 'Data Book Berhasil Ditambahkan!', $book);
    }

    public function show(Book $book)
    {
        //return single post as a resource
        return new PostResource(true, 'Data Book Ditemukan!', $book);
    }

    public function update(Request $request, Book $book)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'release_year' => 'required',
            // 'release_year' => 'required|digits_between:1980,2021',
            'title' => 'required',
            'price' => 'required',
            'total_page' => 'required',
            'category_id' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //check if image is not empty
        if ($request->hasFile('image_url')) {

            //upload image
            $image = $request->file('image_url');
            $image->storeAs('public/books', $image->hashName());

            //delete old image
            Storage::delete('public/books/'.$book->image);

            //update post with new image
            $book->update([
                'image_url' => $image->hashName(),
                'title' => $request->title,
                'description' => $request->description,
                'release_year' => $request->release_year,
                'price' => $request->price,
                'total_page' => $request->total_page,
                'thickness' => $request->thickness,
                'category_id' => $request->category_id,
            ]);

        } else {

            //update post without image
            $book->update([
                'title' => $request->title,
                'description' => $request->description,
                'release_year' => $request->release_year,
                'price' => $request->price,
                'total_page' => $request->total_page,
                'thickness' => $request->thickness,
                'category_id' => $request->category_id,
            ]);
        }

        //return response
        return new PostResource(true, 'Data Book Berhasil Diubah!', $book);
    }

    public function destroy(Book $book)
    {
        //delete image
        Storage::delete('public/posts/'.$book->image);

        //delete post
        $book->delete();

        //return response
        return new PostResource(true, 'Data Book Berhasil Dihapus!', null);
    }
}
